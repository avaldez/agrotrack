

<?php $__env->startSection('content'); ?>
<div class="space-y-4">
    <div>
        <h2 class="text-lg font-bold text-gray-800">Inicio</h2>
        <p class="text-xs text-gray-400"><?php echo e(now()->format('l, d F Y')); ?></p>
    </div>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('estadisticas-inicio');

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3980105842-0', $__key);

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\2023\APPs\agrotrack-1\resources\views\dashboard.blade.php ENDPATH**/ ?>