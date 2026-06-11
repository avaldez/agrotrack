<div>
    <div class="flex items-center gap-3 mb-5">
        <a href="<?php echo e(route('dashboard')); ?>" class="p-2 -ml-2 text-gray-400 hover:text-gray-600 active:bg-gray-100 rounded-full transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Clientes</h2>
            <p class="text-sm text-gray-400">Productores y parcelas</p>
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

    
    <div class="mb-5">
        <div class="relative">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="search" wire:model.live="busqueda" placeholder="Buscar cliente..."
                class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white shadow-sm">
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mostrarFormulario): ?>
        <div class="bg-white border border-gray-100 rounded-xl p-5 mb-6 shadow-md">
            <h3 class="text-base font-bold text-gray-800 mb-4"><?php echo e($editando ? 'Editar' : 'Nuevo'); ?> cliente</h3>
            <form wire:submit.prevent="guardar" class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Nombre / Razón Social *</label>
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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Contacto (Persona)</label>
                        <input type="text" wire:model="contacto"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Teléfono / Celular</label>
                        <input type="tel" inputmode="tel" wire:model="telefono"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Dirección o Zona</label>
                    <input type="text" wire:model="direccion"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-2 block">Grupo WhatsApp (Link o Nombre)</label>
                    <input type="text" wire:model="grupoWhatsapp" placeholder="Ej: https://chat.whatsapp.com/..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                </div>
                <div class="flex flex-col sm:flex-row gap-3 pt-3">
                    <button type="submit"
                        class="w-full py-3.5 bg-agro-500 text-white font-bold rounded-xl text-base hover:bg-agro-600 transition active:scale-[0.98]">
                        <?php echo e($editando ? '💾 Actualizar Cliente' : '💾 Guardar Cliente'); ?>

                    </button>
                    <button type="button" wire:click="resetForm"
                        class="w-full py-3.5 px-4 border-2 border-gray-200 rounded-xl text-base font-bold text-gray-600 active:bg-gray-100 transition">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="space-y-4 pb-24">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm">
                <div class="p-4" wire:key="cliente-<?php echo e($c->id); ?>">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-base font-bold text-gray-800 leading-tight"><?php echo e($c->nombre); ?></h3>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$c->activo): ?>
                                    <span class="text-[10px] px-2 py-0.5 rounded-md bg-gray-100 text-gray-500 font-bold uppercase">Inactivo</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($c->contacto || $c->telefono): ?>
                                <p class="text-sm text-gray-500 mt-1">
                                    <?php echo e($c->contacto ? "👤 {$c->contacto}" : ''); ?><?php echo e($c->contacto && $c->telefono ? ' · ' : ''); ?><?php echo e($c->telefono ? "📱 {$c->telefono}" : ''); ?>

                                </p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="flex flex-wrap items-center gap-2 mt-3">
                                <span class="text-xs px-3 py-1 rounded-lg bg-agro-50 text-agro-700 font-bold border border-agro-100">
                                    📍 <?php echo e($c->parcelas_count); ?> parcela<?php echo e($c->parcelas_count !== 1 ? 's' : ''); ?>

                                </span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($c->grupo_whatsapp): ?>
                                    <span class="text-xs px-3 py-1 rounded-lg bg-[#25D366]/10 text-[#128C7E] font-bold border border-[#25D366]/20">💬 Grupo WA</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar()): ?>
                            <div class="flex flex-col gap-2 ml-3">
                                <button wire:click="editar(<?php echo e($c->id); ?>)"
                                    class="p-2.5 text-gray-500 hover:text-agro-700 bg-gray-50 hover:bg-agro-50 rounded-lg transition active:scale-95 border border-gray-100 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <?php $parcelas = $c->parcelas()->orderBy('nombre')->get(); ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($parcelas->isNotEmpty()): ?>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Parcelas Registradas</h4>
                            <div class="space-y-2">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $parcelas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-100 rounded-xl">
                                        <div>
                                            <span class="block text-sm font-bold text-gray-700"><?php echo e($p->nombre); ?></span>
                                            <div class="text-xs text-gray-500 mt-0.5">
                                                <span class="font-medium text-agro-700"><?php echo e(number_format($p->superficie_ha, 1)); ?> ha</span>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($p->variedad): ?>
                                                    <span class="mx-1">·</span><span><?php echo e($p->variedad); ?></span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar()): ?>
                                            <button wire:click="eliminarParcela(<?php echo e($p->id); ?>)"
                                                wire:confirm="¿Seguro que quieres eliminar esta parcela de <?php echo e(number_format($p->superficie_ha, 1)); ?> ha?"
                                                class="text-gray-400 hover:text-red-500 bg-white p-2 rounded-lg border border-gray-100 shadow-sm active:scale-95 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar()): ?>
                        <button wire:click="abrirParcelaModal(<?php echo e($c->id); ?>)"
                            class="mt-4 w-full py-3 text-sm text-agro-700 bg-agro-50 hover:bg-agro-100 font-bold rounded-xl border border-agro-200 border-dashed transition active:scale-[0.98]">
                            + Agregar parcela
                        </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-12 px-4 border-2 border-dashed border-gray-200 rounded-xl">
                <div class="text-4xl mb-3">🤝</div>
                <h3 class="text-base font-bold text-gray-700 mb-1">Sin clientes</h3>
                <p class="text-sm text-gray-400"><?php echo e($busqueda ? 'No se encontraron resultados para "' . $busqueda . '"' : 'No hay clientes ni productores registrados.'); ?></p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($parcelaModal): ?>
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4 bg-gray-900/60 backdrop-blur-sm transition-opacity" wire:click.self="$set('parcelaModal', false)">
            <div class="bg-white rounded-t-3xl sm:rounded-2xl w-full max-w-sm p-6 sm:p-5 shadow-2xl transform transition-transform" wire:click.stop>
                <div class="w-12 h-1.5 bg-gray-200 rounded-full mx-auto mb-5 sm:hidden"></div>
                <h3 class="text-lg font-bold text-gray-800 mb-5">Nueva parcela para cliente</h3>
                <form wire:submit.prevent="guardarParcela" class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Nombre de Parcela *</label>
                        <input type="text" wire:model="parcelaNombre"
                            class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Superficie (ha) *</label>
                            <input type="number" step="0.1" inputmode="decimal" wire:model="parcelaSuperficie"
                                class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base font-bold text-center focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Cultivo Principal</label>
                            <select wire:model="parcelaCultivoId"
                                class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-white">
                                <option value="">—</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cultivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->id); ?>"><?php echo e($c->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-700 mb-2 block">Variedad</label>
                        <input type="text" wire:model="parcelaVariedad" placeholder="Opcional"
                            class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-gray-50 focus:bg-white">
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button type="submit"
                            class="w-full py-4 bg-agro-500 text-white font-bold rounded-xl text-base hover:bg-agro-600 transition active:scale-[0.98]">
                            💾 Guardar Parcela
                        </button>
                        <button type="button" wire:click="$set('parcelaModal', false)"
                            class="w-full py-4 px-4 border-2 border-gray-200 rounded-xl text-base font-bold text-gray-600 active:bg-gray-100 transition">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\2023\APPs\agrotrack-1\resources\views/livewire/campo/gestion-clientes.blade.php ENDPATH**/ ?>