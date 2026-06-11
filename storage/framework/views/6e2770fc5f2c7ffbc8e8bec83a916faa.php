

<?php $__env->startSection('content'); ?>
<div class="space-y-4">
    <div class="flex items-center gap-3 mb-2">
        <a href="<?php echo e(route('dashboard')); ?>" class="p-1.5 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Usuarios</h2>
            <p class="text-xs text-gray-400">Gestión de usuarios del sistema</p>
        </div>
    </div>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.gestion-usuarios');

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2486687235-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\2023\APPs\agrotrack-1\resources\views\admin\usuarios.blade.php ENDPATH**/ ?>