<div>
    <div class="flex items-center gap-3 mb-5">
        <a href="<?php echo e(route('dashboard')); ?>" class="p-1.5 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Catálogo de Productos</h2>
            <p class="text-xs text-gray-400">Agroquímicos, dosis y precios de referencia</p>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$mostrarFormulario && auth()->user()->puedeMutar()): ?>
            <button wire:click="$set('mostrarFormulario', true)"
                class="ml-auto text-xs px-3 py-1.5 rounded-lg bg-agro-500 text-white font-medium">
                + Nuevo
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('mensaje')): ?>
        <div class="mb-4 p-3 bg-agro-50 border border-agro-200 rounded-xl text-sm text-agro-700">
            <?php echo e(session('mensaje')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="mb-3">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="search" wire:model.live="busqueda" placeholder="Buscar producto..."
                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
        </div>
    </div>

    
    <div class="flex gap-1.5 overflow-x-auto pb-2 scrollbar-hide mb-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button wire:click="$set('categoriaFiltro', '<?php echo e($cat); ?>')"
                class="whitespace-nowrap text-2xs px-3 py-1.5 rounded-full border font-medium transition flex-shrink-0
                <?php echo e($categoriaFiltro === $cat
                    ? 'bg-agro-500 border-agro-500 text-white'
                    : 'bg-white border-gray-200 text-gray-500 hover:border-gray-300'); ?>">
                <?php echo e($cat === 'TODOS' ? 'Todos' : ucfirst(strtolower($cat))); ?>

            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostrarFormulario): ?>
        <div class="bg-white border border-gray-100 rounded-xl p-4 mb-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3"><?php echo e($editando ? 'Editar' : 'Nuevo'); ?> producto</h3>
            <form wire:submit.prevent="guardar" class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nombre *</label>
                    <input type="text" wire:model="nombre"
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
                <div class="grid grid-cols-3 gap-3">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Categoría</label>
                        <select wire:model="categoria"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none bg-white">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat); ?>"><?php echo e(ucfirst(strtolower($cat))); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Unidad</label>
                        <select wire:model="unidad"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none bg-white">
                            <option value="L">L</option>
                            <option value="Kg">Kg</option>
                            <option value="Tn">Tn</option>
                            <option value="Bol">Bol</option>
                            <option value="Dosis">Dosis</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Dosis ref.</label>
                        <input type="number" step="0.001" wire:model="dosis_referencia"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Precio referencia ($)</label>
                    <input type="number" step="0.01" wire:model="precio_referencia"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
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
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-gray-100 rounded-xl p-3.5">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <div class="text-sm font-semibold text-gray-800"><?php echo e($p->nombre); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$p->activo): ?>
                                <span class="text-2xs px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-400">Inactivo</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <span class="text-2xs px-2 py-0.5 rounded-full font-medium inline-block mt-1
                            <?php echo e($p->categoria === 'HERBICIDA' ? 'bg-green-50 text-green-700' : ''); ?>

                            <?php echo e($p->categoria === 'FUNGICIDA' ? 'bg-blue-50 text-blue-700' : ''); ?>

                            <?php echo e($p->categoria === 'INSECTICIDA' ? 'bg-orange-50 text-orange-700' : ''); ?>

                            <?php echo e($p->categoria === 'FERTILIZANTE' ? 'bg-amber-50 text-amber-700' : ''); ?>

                            <?php echo e($p->categoria === 'ADHERENTE' ? 'bg-purple-50 text-purple-700' : ''); ?>

                            <?php echo e($p->categoria === 'SEMILLA' ? 'bg-lime-50 text-lime-700' : ''); ?>

                            <?php echo e(!in_array($p->categoria, ['HERBICIDA','FUNGICIDA','INSECTICIDA','FERTILIZANTE','ADHERENTE','SEMILLA']) ? 'bg-gray-50 text-gray-600' : ''); ?>">
                            <?php echo e($p->categoria); ?>

                        </span>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <div class="text-sm font-bold text-agro-700">$<?php echo e(number_format($p->precio_referencia, 2)); ?></div>
                        <div class="text-2xs text-gray-400">por <?php echo e($p->unidad); ?></div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-50 text-2xs text-gray-400">
                    <span>Dosis ref: <?php echo e($p->dosis_referencia); ?> <?php echo e($p->unidad); ?>/ha</span>
                    <span class="text-agro-600 font-medium">≈ $<?php echo e(number_format($p->dosis_referencia * $p->precio_referencia, 2)); ?>/ha</span>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar()): ?>
                    <div class="flex gap-2 mt-2 pt-2 border-t border-gray-50">
                        <button wire:click="editar(<?php echo e($p->id); ?>)"
                            class="text-xs text-agro-600 hover:text-agro-700 font-medium">
                            Editar
                        </button>
                        <button wire:click="toggleActivo(<?php echo e($p->id); ?>)"
                            class="text-xs text-gray-400 hover:text-red-500 font-medium">
                            <?php echo e($p->activo ? 'Desactivar' : 'Activar'); ?>

                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-8 text-gray-400 text-sm">
                <?php echo e($busqueda ? 'Sin resultados para "' . $busqueda . '"' : 'No hay productos registrados.'); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\2023\APPs\agrotrack-1\resources\views\livewire\campo\gestion-productos.blade.php ENDPATH**/ ?>