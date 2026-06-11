<div>
    <div class="flex items-center gap-3 mb-5">
        <a href="<?php echo e(route('dashboard')); ?>" class="p-1.5 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Zafras / Campañas</h2>
            <p class="text-xs text-gray-400">Gestión de campañas agrícolas</p>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$mostrarFormulario && auth()->user()->puedeMutar()): ?>
            <button wire:click="$set('mostrarFormulario', true)"
                class="ml-auto text-xs px-3 py-1.5 rounded-lg bg-agro-500 text-white font-medium">
                + Nueva
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('mensaje')): ?>
        <div class="mb-4 p-3 bg-agro-50 border border-agro-200 rounded-xl text-sm text-agro-700">
            <?php echo e(session('mensaje')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="mb-4">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="search" wire:model.live="busqueda" placeholder="Buscar zafra..."
                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostrarFormulario): ?>
        <div class="bg-white border border-gray-100 rounded-xl p-4 mb-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3"><?php echo e($editando ? 'Editar' : 'Nueva'); ?> zafra</h3>
            <form wire:submit.prevent="guardar" class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nombre *</label>
                    <input type="text" wire:model="nombre" placeholder="Ej: Zafra 2025-2026"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Fecha inicio *</label>
                        <input type="date" wire:model="fecha_inicio"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Fecha fin</label>
                        <input type="date" wire:model="fecha_fin"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-agro-500 text-white font-medium rounded-xl text-sm hover:bg-agro-600 transition">
                        <?php echo e($editando ? 'Actualizar' : 'Guardar'); ?>

                    </button>
                    <button type="button" wire:click="resetForm"
                        class="py-2.5 px-4 border border-gray-200 rounded-xl text-sm text-gray-500">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="space-y-2">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $zafras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-gray-100 rounded-xl p-3.5">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-semibold text-gray-800"><?php echo e($z->nombre); ?></h3>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($z->activa): ?>
                                <span class="text-2xs px-1.5 py-0.5 rounded-full bg-agro-50 text-agro-700">Activa</span>
                            <?php else: ?>
                                <span class="text-2xs px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-400">Inactiva</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            <?php echo e($z->fecha_inicio->format('d/m/Y')); ?> — <?php echo e($z->fecha_fin?->format('d/m/Y') ?? 'Sin fecha fin'); ?>

                        </div>
                        <div class="flex items-center gap-2 mt-1.5">
                            <span class="text-2xs px-2 py-0.5 rounded-full bg-blue-50 text-blue-700">
                                <?php echo e($z->visitas_count); ?> visita<?php echo e($z->visitas_count !== 1 ? 's' : ''); ?>

                            </span>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar()): ?>
                        <div class="flex items-center gap-1 ml-2">
                            <button wire:click="editar(<?php echo e($z->id); ?>)"
                                class="p-1.5 text-gray-300 hover:text-agro-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button wire:click="toggleActivo(<?php echo e($z->id); ?>)"
                                class="p-1.5 text-gray-300 hover:text-<?php echo e($z->activa ? 'red' : 'agro'); ?>-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M<?php echo e($z->activa ? 'M6 18L18 6M6 6l12 12' : 'M12 4v16m8-8H4'); ?>"/>
                                </svg>
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-8 text-gray-400 text-sm">
                <?php echo e($busqueda ? 'Sin resultados para "' . $busqueda . '"' : 'No hay zafras registradas.'); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\2023\APPs\agrotrack-1\resources\views\livewire\admin\gestion-zafras.blade.php ENDPATH**/ ?>