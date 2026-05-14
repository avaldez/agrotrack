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

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3245979098-0', $__key);

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
<?php /**PATH C:\tmp\agrotrack\resources\views/livewire/dashboard.blade.php ENDPATH**/ ?>