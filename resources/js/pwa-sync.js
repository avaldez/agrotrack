const DB_NAME = 'AGROTRACK_SYNC';
const DB_VERSION = 1;
const STORE_NAME = 'visitas_pendientes';

export function openDB() {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open(DB_NAME, DB_VERSION);
        request.onupgradeneeded = (event) => {
            const db = event.target.result;
            if (!db.objectStoreNames.contains(STORE_NAME)) {
                db.createObjectStore(STORE_NAME, { keyPath: 'id', autoIncrement: true });
            }
        };
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

export async function guardarVisitaOffline(visitaData, csrfToken) {
    const db = await openDB();
    const tx = db.transaction(STORE_NAME, 'readwrite');
    const store = tx.objectStore(STORE_NAME);
    return new Promise((resolve, reject) => {
        const request = store.add({
            data: visitaData,
            csrf: csrfToken,
            created_at: new Date().toISOString(),
        });
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => reject(request.error);
    });
}

export async function getPendientesCount() {
    const db = await openDB();
    const tx = db.transaction(STORE_NAME, 'readonly');
    const store = tx.objectStore(STORE_NAME);
    return new Promise((resolve) => {
        const request = store.count();
        request.onsuccess = () => resolve(request.result);
        request.onerror = () => resolve(0);
    });
}

export async function sincronizarAhora() {
    if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
        navigator.serviceWorker.controller.postMessage({ type: 'SYNC_NOW' });
    }
}

export function initPwaSync() {
    window.addEventListener('online', () => {
        const banner = document.getElementById('offline-banner');
        if (banner) banner.classList.add('hidden');
        sincronizarAhora();
    });

    window.addEventListener('offline', () => {
        const banner = document.getElementById('offline-banner');
        if (banner) banner.classList.remove('hidden');
    });

    if (navigator.serviceWorker) {
        navigator.serviceWorker.addEventListener('message', (event) => {
            if (event.data?.type === 'SYNC_COMPLETED') {
                const toast = document.getElementById('sync-toast');
                if (toast) {
                    toast.classList.remove('hidden');
                    setTimeout(() => toast.classList.add('hidden'), 3000);
                }
                window.dispatchEvent(new CustomEvent('sync-completed'));
            }
        });
    }
}
