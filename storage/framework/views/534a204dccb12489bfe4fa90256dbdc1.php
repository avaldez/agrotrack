<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#1D9E75">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="AGROTRACK">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { agro: { 50: '#E1F5EE', 100: '#C3EBDE', 200: '#A8E0CC', 500: '#1D9E75', 600: '#0F6E56', 700: '#085041' } },
                    fontSize: { '2xs': '0.65rem' }
                }
            }
        }
    </script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <style>
        * { -webkit-tap-highlight-color: transparent; }
        body { overscroll-behavior-y: contain; }
        .safe-bottom { padding-bottom: env(safe-area-inset-bottom, 0px); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        @keyframes slide-up { from { transform: translateY(100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .animate-slide-up { animation: slide-up 0.25s ease-out; }
    </style>
</head>
<body class="h-full bg-gray-50 text-gray-800 font-sans antialiased">
    <div id="offline-banner" class="hidden fixed top-0 left-0 right-0 z-50 bg-amber-500 text-white text-center text-xs py-1.5 font-medium">
        <svg class="inline w-3.5 h-3.5 mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 12.728m12.728-12.728a9 9 0 00-12.728 12.728m12.728-12.728L5.636 18.364"/>
        </svg>
        Sin conexión — los datos se guardarán localmente
    </div>

    <div id="sync-toast" class="hidden fixed bottom-20 left-4 right-4 z-50 bg-agro-600 text-white text-center text-sm py-2.5 px-4 rounded-xl shadow-lg animate-slide-up max-w-xs mx-auto">
        <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Datos sincronizados correctamente
    </div>

    <div class="max-w-xl mx-auto bg-white min-h-screen relative flex flex-col shadow-sm">
        <header class="sticky top-0 z-40 bg-white border-b border-gray-100 px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <img src="/images/logo.png" alt="AGROTRACK" class="h-8 w-auto">
                    <div>
                        <div class="text-sm font-semibold leading-tight">AGROTRACK</div>
                        <div class="text-2xs text-gray-400 leading-tight"><?php echo e(auth()->user()->name); ?></div>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <span class="text-2xs px-2 py-0.5 rounded-full font-medium
                        <?php echo e(auth()->user()->isAdmin() ? 'bg-purple-100 text-purple-700' : ''); ?>

                        <?php echo e(auth()->user()->isTecnico() ? 'bg-agro-50 text-agro-700' : ''); ?>

                        <?php echo e(auth()->user()->isConsulta() ? 'bg-gray-100 text-gray-600' : ''); ?>">
                        <?php echo e(auth()->user()->role); ?>

                    </span>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="flex-1 px-4 py-4 pb-36 overflow-y-auto">
            <?php echo e($slot ?? ''); ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-100 safe-bottom max-w-xl mx-auto">
            <div class="flex justify-around py-2">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex flex-col items-center gap-0.5 text-2xs px-3 py-1 <?php echo e(request()->routeIs('dashboard') ? 'text-agro-500' : 'text-gray-400'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Inicio</span>
                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar()): ?>
                <a href="<?php echo e(route('campo.registrar')); ?>" class="flex flex-col items-center gap-0.5 text-2xs px-3 py-1 <?php echo e(request()->routeIs('campo.registrar') ? 'text-agro-500' : 'text-gray-400'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    <span>Registrar</span>
                </a>
                <a href="<?php echo e(route('campo.recorridos')); ?>" class="flex flex-col items-center gap-0.5 text-2xs px-3 py-1 <?php echo e(request()->routeIs('campo.recorridos') ? 'text-agro-500' : 'text-gray-400'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>Recorridos</span>
                </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <a href="<?php echo e(route('productos')); ?>" class="flex flex-col items-center gap-0.5 text-2xs px-3 py-1 <?php echo e(request()->routeIs('productos') ? 'text-agro-500' : 'text-gray-400'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Productos</span>
                </a>
                <a href="<?php echo e(route('clientes')); ?>" class="flex flex-col items-center gap-0.5 text-2xs px-3 py-1 <?php echo e(request()->routeIs('clientes') ? 'text-agro-500' : 'text-gray-400'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span>Clientes</span>
                </a>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar()): ?>
            <div class="flex justify-around py-2 border-t border-gray-50">
                <a href="<?php echo e(route('admin.zafras')); ?>" class="flex flex-col items-center gap-0.5 text-2xs px-3 py-1 <?php echo e(request()->routeIs('admin.zafras') ? 'text-agro-500' : 'text-gray-400'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Zafras</span>
                </a>
                <a href="<?php echo e(route('admin.usuarios')); ?>" class="flex flex-col items-center gap-0.5 text-2xs px-3 py-1 <?php echo e(request()->routeIs('admin.usuarios') ? 'text-agro-500' : 'text-gray-400'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Usuarios</span>
                </a>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </nav>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').then((reg) => {
                    console.log('SW registered:', reg.scope);
                }).catch((err) => {
                    console.log('SW registration failed:', err);
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (!navigator.onLine) {
                const banner = document.getElementById('offline-banner');
                if (banner) banner.classList.remove('hidden');
            }
        });
    </script>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

</body>
</html>
<?php /**PATH C:\2023\APPs\agrotrack-1\resources\views/layouts/app.blade.php ENDPATH**/ ?>