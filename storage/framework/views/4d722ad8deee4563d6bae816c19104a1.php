<!DOCTYPE html>
<html lang="es" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>AGROTRACK - Iniciar sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { agro: { 50: '#E1F5EE', 100: '#C3EBDE', 500: '#1D9E75', 600: '#0F6E56', 700: '#085041' } }
                }
            }
        }
    </script>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-b from-agro-500 to-agro-700">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <img src="/images/logo.png" alt="AGROTRACK" class="h-16 mx-auto mb-3">
            <p class="text-emerald-100 text-sm">Asistencia Técnica Agropecuaria</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Bienvenido</h2>
            <p class="text-sm text-gray-500 mb-6">Ingresá tus credenciales</p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                    <?php echo e($errors->first('email')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none"
                        placeholder="tech@agroservicio.com">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Contraseña</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none"
                        placeholder="••••••••">
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-500">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-agro-500 focus:ring-agro-500">
                        Recordarme
                    </label>
                </div>
                <button type="submit"
                    class="w-full py-3 bg-agro-500 text-white font-medium rounded-xl text-sm hover:bg-agro-600 transition active:scale-[0.98]">
                    Ingresar
                </button>
            </form>
        </div>

        <p class="text-center text-emerald-200 text-xs mt-6">AGROTRACK v1.0 &mdash; El Campo Productivo</p>
    </div>
</body>
</html>
<?php /**PATH C:\tmp\agrotrack\resources\views/auth/login.blade.php ENDPATH**/ ?>