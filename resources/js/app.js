import './bootstrap';
import { initPwaSync, guardarVisitaOffline, getPendientesCount } from './pwa-sync';

// Inicializar sincronización PWA
initPwaSync();

// Exponer para Livewire
window.guardarVisitaOffline = guardarVisitaOffline;
window.getPendientesCount = getPendientesCount;

// Detectar cambios de conexión y mostrar contador
document.addEventListener('DOMContentLoaded', async () => {
    const count = await getPendientesCount();
    if (count > 0) {
        const badge = document.getElementById('sync-badge');
        if (badge) {
            badge.textContent = count;
            badge.classList.remove('hidden');
        }
    }
});
