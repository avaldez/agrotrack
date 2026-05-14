const CACHE_NAME = 'agrotrack-v1';
const STATIC_ASSETS = [
  '/',
  '/offline',
  '/manifest.json',
  '/icons/icon-192.png',
  '/icons/icon-512.png',
  '/build/assets/app.css',
  '/build/assets/app.js',
];

const API_CACHE = 'agrotrack-api-v1';
const SYNC_QUEUE = 'agrotrack-sync-queue';

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(STATIC_ASSETS);
    })
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.filter((k) => k !== CACHE_NAME && k !== API_CACHE)
          .map((k) => caches.delete(k))
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  if (request.method !== 'GET') return;

  if (url.pathname.startsWith('/api/')) {
    event.respondWith(networkFirstWithCache(request, API_CACHE));
    return;
  }

  if (STATIC_ASSETS.includes(url.pathname) || /\.(css|js|png|jpg|svg|woff2?)$/.test(url.pathname)) {
    event.respondWith(cacheFirst(request));
    return;
  }

  if (url.pathname.startsWith('/livewire/')) {
    event.respondWith(networkFirstWithCache(request, CACHE_NAME));
    return;
  }

  event.respondWith(networkFirst(request));
});

async function cacheFirst(request) {
  const cached = await caches.match(request);
  return cached || fetchAndCache(request, CACHE_NAME);
}

async function networkFirst(request) {
  try {
    return await fetchAndCache(request, CACHE_NAME);
  } catch {
    const cached = await caches.match(request);
    return cached || caches.match('/offline');
  }
}

async function networkFirstWithCache(request, cacheName) {
  try {
    return await fetchAndCache(request, cacheName);
  } catch {
    const cached = await caches.match(request);
    return cached || new Response(JSON.stringify({ offline: true }), {
      headers: { 'Content-Type': 'application/json' },
    });
  }
}

async function fetchAndCache(request, cacheName) {
  const response = await fetch(request);
  if (response.ok) {
    const cache = await caches.open(cacheName);
    cache.put(request, response.clone());
  }
  return response;
}

self.addEventListener('message', (event) => {
  if (event.data?.type === 'SYNC_NOW') {
    triggerSync();
  }
});

self.addEventListener('sync', (event) => {
  if (event.tag === 'sync-visitas') {
    event.waitUntil(syncPendingVisitas());
  }
});

async function triggerSync() {
  const clients = await self.clients.matchAll();
  clients.forEach((client) => client.postMessage({ type: 'SYNC_STARTED' }));
  await syncPendingVisitas();
  clients.forEach((client) => client.postMessage({ type: 'SYNC_COMPLETED' }));
}

async function syncPendingVisitas() {
  try {
    const db = await openIndexedDB();
    const tx = db.transaction('visitas_pendientes', 'readonly');
    const store = tx.objectStore('visitas_pendientes');
    const pendientes = await store.getAll();

    for (const item of pendientes) {
      try {
        const response = await fetch('/api/sync/visita', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': item.csrf },
          body: JSON.stringify(item.data),
        });
        if (response.ok) {
          const deleteTx = db.transaction('visitas_pendientes', 'readwrite');
          const deleteStore = deleteTx.objectStore('visitas_pendientes');
          deleteStore.delete(item.id);
        }
      } catch (err) {
        console.error('Sync failed for item', item.id, err);
      }
    }
  } catch (err) {
    console.error('IndexedDB sync error:', err);
  }
}

function openIndexedDB() {
  return new Promise((resolve, reject) => {
    const request = indexedDB.open('AGROTRACK_SYNC', 1);
    request.onupgradeneeded = (event) => {
      const db = event.target.result;
      if (!db.objectStoreNames.contains('visitas_pendientes')) {
        db.createObjectStore('visitas_pendientes', { keyPath: 'id', autoIncrement: true });
      }
    };
    request.onsuccess = () => resolve(request.result);
    request.onerror = () => reject(request.error);
  });
}
