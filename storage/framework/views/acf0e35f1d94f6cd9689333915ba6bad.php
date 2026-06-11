<div>
    <div class="flex items-center gap-3 mb-5">
        <a href="<?php echo e(route('dashboard')); ?>" class="p-2 -ml-2 text-gray-400 hover:text-gray-600 active:bg-gray-100 rounded-full transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Catálogo</h2>
            <p class="text-sm text-gray-400">Productos y precios</p>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$mostrarFormulario && auth()->user()->puedeMutar()): ?>
            <button wire:click="$set('mostrarFormulario', true)"
                class="ml-auto text-sm px-4 py-2 rounded-xl bg-agro-500 text-white font-bold hover:bg-agro-600 active:scale-95 transition">
                + Nuevo
            </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('mensaje')): ?>
        <div class="mb-4 p-4 bg-agro-50 border border-agro-200 rounded-xl text-base text-agro-700">
            <?php echo e(session('mensaje')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="mb-4">
        <div class="relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="search" wire:model.live="busqueda" placeholder="Buscar producto..."
                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white shadow-sm">
        </div>
    </div>

    
    <div class="flex gap-2 overflow-x-auto pb-3 scrollbar-hide mb-4 -mx-4 px-4 sm:mx-0 sm:px-0" style="scroll-snap-type: x mandatory;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button wire:click="$set('categoriaFiltro', '<?php echo e($cat); ?>')" style="scroll-snap-align: start;"
                class="whitespace-nowrap text-sm px-5 py-2.5 rounded-full border-2 font-bold transition flex-shrink-0
                <?php echo e($categoriaFiltro === $cat
                    ? 'bg-agro-500 border-agro-500 text-white shadow-md'
                    : 'bg-white border-gray-200 text-gray-600 hover:border-gray-300 active:bg-gray-50'); ?>">
                <?php echo e($cat === 'TODOS' ? 'Todos' : ucfirst(strtolower($cat))); ?>

            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostrarFormulario): ?>
        <div class="bg-white border border-gray-100 rounded-xl p-5 mb-6 shadow-md">
            <h3 class="text-base font-bold text-gray-800 mb-4"><?php echo e($editando ? 'Editar' : 'Nuevo'); ?> producto</h3>
            <form wire:submit.prevent="guardar" class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Nombre *</label>
                    <input type="text" wire:model="nombre"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-sm text-red-500 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Categoría</label>
                        <select wire:model="categoria"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-white">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cat !== 'TODOS'): ?>
                                    <option value="<?php echo e($cat); ?>"><?php echo e(ucfirst(strtolower($cat))); ?></option>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 sm:col-span-2">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Unidad</label>
                            <select wire:model="unidad"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-white">
                                <option value="L">L</option>
                                <option value="Kg">Kg</option>
                                <option value="Tn">Tn</option>
                                <option value="Bol">Bol</option>
                                <option value="Dosis">Dosis</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Dosis ref.</label>
                            <input type="number" step="0.001" inputmode="decimal" wire:model="dosis_referencia"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Precio referencia ($)</label>
                    <input type="number" step="0.01" inputmode="decimal" wire:model="precio_referencia"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base font-bold focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                </div>
                <div class="flex flex-col sm:flex-row gap-3 pt-3">
                    <button type="submit"
                        class="w-full py-3.5 bg-agro-500 text-white font-bold rounded-xl text-base hover:bg-agro-600 transition active:scale-[0.98]">
                        <?php echo e($editando ? '💾 Actualizar' : '💾 Guardar'); ?>

                    </button>
                    <button type="button" wire:click="resetForm"
                        class="w-full py-3.5 px-4 border-2 border-gray-200 rounded-xl text-base font-bold text-gray-600 active:bg-gray-100 transition">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="space-y-3 pb-24">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="text-base font-bold text-gray-800 leading-tight"><?php echo e($p->nombre); ?></h3>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$p->activo): ?>
                                <span class="text-[10px] px-2 py-0.5 rounded-md bg-gray-100 text-gray-500 font-bold uppercase">Inactivo</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <span class="text-xs px-2.5 py-1 rounded-lg font-bold inline-block mt-1
                            <?php echo e($p->categoria === 'HERBICIDA' ? 'bg-green-50 text-green-700' : ''); ?>

                            <?php echo e($p->categoria === 'FUNGICIDA' ? 'bg-blue-50 text-blue-700' : ''); ?>

                            <?php echo e($p->categoria === 'INSECTICIDA' ? 'bg-orange-50 text-orange-700' : ''); ?>

                            <?php echo e($p->categoria === 'FERTILIZANTE' ? 'bg-amber-50 text-amber-700' : ''); ?>

                            <?php echo e($p->categoria === 'ADHERENTE' ? 'bg-purple-50 text-purple-700' : ''); ?>

                            <?php echo e($p->categoria === 'SEMILLA' ? 'bg-lime-50 text-lime-700' : ''); ?>

                            <?php echo e(!in_array($p->categoria, ['HERBICIDA','FUNGICIDA','INSECTICIDA','FERTILIZANTE','ADHERENTE','SEMILLA']) ? 'bg-gray-100 text-gray-600' : ''); ?>">
                            <?php echo e($p->categoria); ?>

                        </span>
                    </div>
                    <div class="text-right flex-shrink-0 bg-gray-50 p-2 rounded-xl border border-gray-100 min-w-[80px]">
                        <div class="text-lg font-black text-agro-700 leading-none">$<?php echo e(number_format($p->precio_referencia, 2)); ?></div>
                        <div class="text-[10px] text-gray-400 font-medium uppercase mt-1">/ <?php echo e($p->unidad); ?></div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between mt-3 p-3 bg-gray-50/50 rounded-lg border border-gray-100 text-sm">
                    <span class="text-gray-500 font-medium">Dosis: <strong class="text-gray-700"><?php echo e($p->dosis_referencia); ?> <?php echo e($p->unidad); ?>/ha</strong></span>
                    <span class="text-agro-700 font-bold">≈ $<?php echo e(number_format($p->dosis_referencia * $p->precio_referencia, 2)); ?>/ha</span>
                </div>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar()): ?>
                    <div class="grid grid-cols-2 gap-2 mt-3 pt-3 border-t border-gray-100">
                        <button wire:click="editar(<?php echo e($p->id); ?>)"
                            class="py-2.5 px-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 active:bg-gray-100 transition shadow-sm text-center">
                            ✏️ Editar
                        </button>
                        <button wire:click="toggleActivo(<?php echo e($p->id); ?>)"
                            class="py-2.5 px-2 bg-white border border-gray-200 rounded-lg text-sm font-bold <?php echo e($p->activo ? 'text-red-600' : 'text-green-600'); ?> hover:bg-gray-50 active:bg-gray-100 transition shadow-sm text-center">
                            <?php echo e($p->activo ? '⛔ Desactivar' : '✅ Activar'); ?>

                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-12 px-4 border-2 border-dashed border-gray-200 rounded-xl">
                <div class="text-4xl mb-3">📦</div>
                <h3 class="text-base font-bold text-gray-700 mb-1">Sin productos</h3>
                <p class="text-sm text-gray-400"><?php echo e($busqueda ? 'No se encontraron resultados para "' . $busqueda . '"' : 'No hay productos registrados en el catálogo.'); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\2023\APPs\agrotrack-1\resources\views/livewire/campo/gestion-productos.blade.php ENDPATH**/ ?>