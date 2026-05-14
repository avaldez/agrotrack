<div>
    
    <div class="flex items-center gap-3 mb-5">
        <a href="<?php echo e(route('dashboard')); ?>" class="p-1.5 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Nuevo recorrido</h2>
            <p class="text-xs text-gray-400">Registrá tu visita a campo</p>
        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mensajeExito): ?>
        <div class="mb-4 p-3 bg-agro-50 border border-agro-200 rounded-xl text-sm text-agro-700 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <?php echo e($mensajeExito); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($mensajeError): ?>
        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <?php echo e($mensajeError); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form wire:submit.prevent="guardar" class="space-y-4">
        
        <div class="bg-white border border-gray-100 rounded-xl p-4">
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Fecha del recorrido</label>
                <input type="date" wire:model="fechaRecorrido"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['fechaRecorrido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Técnicos presentes</label>
                <div class="flex flex-wrap gap-1.5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tecnicosDisponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-xs cursor-pointer transition
                            <?php echo e(in_array($t->id, $tecnicosSeleccionados) ? 'bg-agro-50 border-agro-500 text-agro-700' : 'bg-white border-gray-200 text-gray-500'); ?>">
                            <input type="checkbox" value="<?php echo e($t->id); ?>"
                                <?php echo e(in_array($t->id, $tecnicosSeleccionados) ? 'checked' : ''); ?>

                                wire:model="tecnicosSeleccionados" class="hidden">
                            <?php echo e($t->name); ?>

                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tecnicosSeleccionados'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <div class="bg-white border border-gray-100 rounded-xl p-4">
            <div class="grid grid-cols-1 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Cliente / Productor</label>
                    <select wire:model.live="clienteId"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                        <option value="">Seleccionar cliente...</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['clienteId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Parcela</label>
                    <select wire:model="parcelaId"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                        <option value="">Seleccionar parcela...</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $parcelasDisponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p->id); ?>"><?php echo e($p->nombre); ?> (<?php echo e($p->superficie_ha); ?> ha)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['parcelaId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="bg-white border border-gray-100 rounded-xl p-4">
            <label class="block text-xs font-medium text-gray-600 mb-2">Tipo de visita</label>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" wire:click="$set('tipoVisita', 'MONITOREO')"
                    class="py-3 px-4 rounded-xl border text-sm font-medium transition text-center
                    <?php echo e($tipoVisita === 'MONITOREO' ? 'bg-agro-50 border-agro-500 text-agro-700' : 'bg-white border-gray-200 text-gray-500'); ?>">
                    <div class="text-lg mb-0.5">🔍</div>
                    Solo monitoreo
                </button>
                <button type="button" wire:click="$set('tipoVisita', 'RECOMENDACION')"
                    class="py-3 px-4 rounded-xl border text-sm font-medium transition text-center
                    <?php echo e($tipoVisita === 'RECOMENDACION' ? 'bg-agro-50 border-agro-500 text-agro-700' : 'bg-white border-gray-200 text-gray-500'); ?>">
                    <div class="text-lg mb-0.5">📋</div>
                    Con recomendación
                </button>
            </div>
        </div>

        
        <div class="bg-white border border-gray-100 rounded-xl p-4">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Cultivo</label>
                    <select wire:model="cultivoId"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                        <option value="">—</option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cultivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Variedad</label>
                    <input type="text" wire:model="variedadObservada" placeholder="Ej: DM 66I68"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none">
                </div>
            </div>
            <div class="mt-3">
                <label class="block text-xs font-medium text-gray-600 mb-1.5">Zafra / Campaña</label>
                <select wire:model="zafraId"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                    <option value="">—</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $zafras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $z): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($z->id); ?>"><?php echo e($z->nombre); ?> (<?php echo e($z->fecha_inicio->format('d/m/Y')); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
        </div>

        
        <div class="bg-white border border-gray-100 rounded-xl p-4">
            <label class="block text-xs font-medium text-gray-600 mb-3">Estado observado del cultivo</label>
            <div class="space-y-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
                    'estadoGeneral' => 'General',
                    'estadoPlagas' => 'Plagas',
                    'estadoEnfermedades' => 'Enfermedades',
                    'estadoHumedad' => 'Humedad',
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campo => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div>
                        <span class="text-xs text-gray-500 mb-1.5 block"><?php echo e($label); ?></span>
                        <div class="flex gap-1.5">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['ok' => '✅ Sin novedad', 'warn' => '⚠️ Leve', 'bad' => '❌ Alta']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $txt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button type="button" wire:click="$set('<?php echo e($campo); ?>', '<?php echo e($val); ?>')"
                                    class="flex-1 py-2 px-2 rounded-lg border text-xs font-medium transition text-center
                                    <?php echo e(${$campo} === $val ? ($val === 'ok' ? 'bg-agro-50 border-agro-500 text-agro-700' : ($val === 'warn' ? 'bg-amber-50 border-amber-400 text-amber-700' : 'bg-red-50 border-red-400 text-red-700')) : 'bg-white border-gray-200 text-gray-400'); ?>">
                                    <?php echo e($txt); ?>

                                </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipoVisita === 'RECOMENDACION'): ?>
            <div class="bg-white border border-gray-100 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <label class="text-xs font-medium text-gray-600">Productos recomendados</label>
                    <button type="button" wire:click="addProducto"
                        class="text-xs px-3 py-1.5 rounded-lg bg-agro-500 text-white font-medium hover:bg-agro-600 transition">
                        + Agregar
                    </button>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['productos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500 mb-2 block"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($productos) === 0): ?>
                    <p class="text-xs text-gray-400 text-center py-4">No hay productos. Agregá los productos de la mezcla de tanque.</p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="space-y-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-start gap-2 p-2.5 bg-gray-50 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <select wire:model.live="productoSelect.<?php echo e($index); ?>"
                                    class="w-full px-2.5 py-2 rounded-lg border border-gray-200 text-xs focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                                    <option value="">Seleccionar producto...</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $productosCatalogo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($pCat->id); ?>"><?php echo e($pCat->nombre); ?> (<?php echo e($pCat->categoria); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prod['producto_id']): ?>
                                    <div class="flex items-center gap-2 mt-1.5">
                                        <input type="number" step="0.01" wire:model.live="productos.<?php echo e($index); ?>.dosis"
                                            class="w-20 px-2 py-1.5 rounded-lg border border-gray-200 text-xs text-center focus:ring-1 focus:ring-agro-500 outline-none"
                                            placeholder="Dosis">
                                        <span class="text-2xs text-gray-400"><?php echo e($prod['unidad']); ?>/ha</span>
                                        <span class="text-xs font-medium text-agro-700 ml-auto">
                                            $<?php echo e(number_format($prod['costo'], 2)); ?>

                                        </span>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <button type="button" wire:click="removeProducto(<?php echo e($index); ?>)"
                                class="p-1.5 text-gray-300 hover:text-red-500 transition flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->user()->puedeMutar() && $totalCostoHa > 0): ?>
                    <div class="mt-3 p-2.5 bg-amber-50 border border-amber-200 rounded-lg flex items-center justify-between">
                        <span class="text-xs font-medium text-amber-700">💰 Costo estimado</span>
                        <span class="text-sm font-bold text-amber-800">$<?php echo e(number_format($totalCostoHa, 2)); ?>/ha</span>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="bg-white border border-gray-100 rounded-xl p-4">
            <div class="mb-3">
                <label class="block text-xs font-medium text-gray-600 mb-1.5">
                    🔒 Observación interna (solo técnico)
                </label>
                <textarea wire:model="observacionTecnico" rows="2"
                    class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none resize-none"
                    placeholder="Notas internas, historial, seguimiento..."></textarea>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipoVisita === 'RECOMENDACION'): ?>
                <div class="mb-3">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">
                        💬 Observación para el productor
                    </label>
                    <textarea wire:model="observacionProductor" rows="2"
                        class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none resize-none"
                        placeholder="Texto que acompaña al informe..."></textarea>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Tipo de aplicación</label>
                    <select wire:model="tipoAplicacion"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                        <option value="">—</option>
                        <option>HERBICIDA</option>
                        <option>FUNGICIDA</option>
                        <option>INSECTICIDA</option>
                        <option>FERTILIZACIÓN</option>
                        <option>DESECACIÓN</option>
                        <option>COBERTURA</option>
                        <option>OTROS</option>
                    </select>
                </div>
                <div class="mt-3">
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">Hectáreas aplicadas</label>
                    <input type="number" step="0.5" wire:model="hectareasAplicadas"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none"
                        placeholder="0.00">
                </div>
            <?php else: ?>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1.5">
                        Motivo / observación (sin recomendación)
                    </label>
                    <textarea wire:model="sinRecomendacionMotivo" rows="2"
                        class="w-full px-3 py-2 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none resize-none"
                        placeholder="Todo en orden, cultivo sin novedades..."></textarea>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="flex gap-3">
            <button type="submit" wire:loading.attr="disabled"
                class="flex-1 py-3 bg-agro-500 text-white font-medium rounded-xl text-sm hover:bg-agro-600 transition active:scale-[0.98] disabled:opacity-50">
                <span wire:loading.remove>💾 Guardar visita</span>
                <span wire:loading>Guardando...</span>
            </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tipoVisita === 'RECOMENDACION' && count($productos) > 0): ?>
                <button type="button" wire:click="generarMensajeWhatsApp"
                    class="py-3 px-4 bg-green-500 text-white font-medium rounded-xl text-sm hover:bg-green-600 transition active:scale-[0.98]">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </form>

    
    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('guardar-offline', async (event) => {
                const { data } = event;
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

                if (window.guardarVisitaOffline) {
                    await window.guardarVisitaOffline(data, csrf);
                }
            });

            Livewire.on('abrir-whatsapp', (event) => {
                window.open(event.url, '_blank');
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
</div>
<?php /**PATH C:\tmp\agrotrack\resources\views/livewire/campo/registrar-visita.blade.php ENDPATH**/ ?>