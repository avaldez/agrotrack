<div>
    
    <div class="grid grid-cols-3 gap-3 mb-5">
        <div class="bg-agro-50 rounded-xl p-3.5 text-center">
            <div class="text-2xl font-bold text-agro-700"><?php echo e($totalClientes); ?></div>
            <div class="text-2xs text-agro-600 mt-0.5">Clientes activos</div>
        </div>
        <div class="bg-blue-50 rounded-xl p-3.5 text-center">
            <div class="text-2xl font-bold text-blue-700"><?php echo e($totalRecorridos); ?></div>
            <div class="text-2xs text-blue-600 mt-0.5">Recorridos</div>
        </div>
        <div class="bg-amber-50 rounded-xl p-3.5 text-center">
            <div class="text-2xl font-bold text-amber-700"><?php echo e($proximasVisitas->count()); ?></div>
            <div class="text-2xs text-amber-600 mt-0.5">Visitas recientes</div>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ultimoRecorrido): ?>
        <div class="bg-white border border-gray-100 rounded-xl p-4 mb-4">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-700">Último recorrido</h3>
                <span class="text-2xs text-gray-400"><?php echo e($ultimoRecorrido->fecha_recorrido->format('d/m/Y')); ?></span>
            </div>
            <div class="flex flex-wrap gap-1.5 mb-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $ultimoRecorrido->tecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="text-2xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600"><?php echo e($t->name); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ultimoRecorrido->observacion_general): ?>
                <p class="text-xs text-gray-500 italic"><?php echo e($ultimoRecorrido->observacion_general); ?></p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <a href="<?php echo e(route('campo.recorridos')); ?>" class="inline-block mt-3 text-xs font-medium text-agro-600 hover:text-agro-700">
                Ver todos los recorridos →
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar()): ?>
        <div class="grid grid-cols-2 gap-3">
            <a href="<?php echo e(route('campo.registrar')); ?>"
                class="flex items-center gap-3 bg-agro-500 text-white rounded-xl p-4 active:scale-[0.98] transition">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-semibold">Nuevo recorrido</div>
                    <div class="text-2xs text-white/80">Registrar visita a campo</div>
                </div>
            </a>
            <a href="<?php echo e(route('clientes')); ?>"
                class="flex items-center gap-3 bg-white border border-gray-200 rounded-xl p-4 active:scale-[0.98] transition">
                <div class="w-10 h-10 rounded-lg bg-agro-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-agro-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-semibold text-gray-700">Clientes</div>
                    <div class="text-2xs text-gray-400">Gestionar productores</div>
                </div>
            </a>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\2023\APPs\agrotrack-1\resources\views\livewire\estadisticas-inicio.blade.php ENDPATH**/ ?>