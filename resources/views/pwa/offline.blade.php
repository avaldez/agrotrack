<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sin conexión - AGROTRACK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-agro { background-color: #1D9E75; }
        .text-agro { color: #1D9E75; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="text-center max-w-sm">
        <div class="w-20 h-20 mx-auto mb-5 rounded-full bg-gray-200 flex items-center justify-center">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18.364 5.636a9 9 0 11-12.728 12.728m12.728-12.728a9 9 0 00-12.728 12.728m12.728-12.728L5.636 18.364"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-gray-800 mb-2">Sin conexión a Internet</h1>
        <p class="text-gray-500 text-sm mb-6">
            AGROTRACK está en modo offline. Tus visitas se guardarán localmente
            y se sincronizarán automáticamente cuando recuperes conexión.
        </p>
        <button onclick="window.location.reload()"
            class="bg-agro text-white px-6 py-3 rounded-xl font-medium text-sm hover:bg-emerald-700 transition">
            Reintentar conexión
        </button>
        <p class="mt-4 text-xs text-gray-400">
            Los datos ingresados en modo offline se sincronizarán automáticamente.
        </p>
    </div>
</body>
</html>
