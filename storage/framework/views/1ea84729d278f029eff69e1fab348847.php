<div>
    <div class="flex items-center gap-3 mb-5">
        <a href="<?php echo e(route('dashboard')); ?>" class="p-1.5 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Recorridos</h2>
            <p class="text-xs text-gray-400">Historial de visitas a campo</p>
        </div>
    </div>

    
    <div class="bg-white border border-gray-100 rounded-xl p-3.5 mb-4 space-y-2">
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="text-2xs text-gray-500 mb-1 block">Desde</label>
                <input type="date" wire:model.live="filtroFechaDesde"
                    class="w-full px-2.5 py-2 rounded-lg border border-gray-200 text-xs focus:ring-1 focus:ring-agro-500 outline-none">
            </div>
            <div>
                <label class="text-2xs text-gray-500 mb-1 block">Hasta</label>
                <input type="date" wire:model.live="filtroFechaHasta"
                    class="w-full px-2.5 py-2 rounded-lg border border-gray-200 text-xs focus:ring-1 focus:ring-agro-500 outline-none">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="text-2xs text-gray-500 mb-1 block">Técnico</label>
                <select wire:model.live="filtroTecnico"
                    class="w-full px-2.5 py-2 rounded-lg border border-gray-200 text-xs focus:ring-1 focus:ring-agro-500 outline-none bg-white">
                    <option value="">Todos</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tecnicosList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->id); ?>"><?php echo e($t->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
            <div>
                <label class="text-2xs text-gray-500 mb-1 block">Cliente</label>
                <select wire:model.live="filtroCliente"
                    class="w-full px-2.5 py-2 rounded-lg border border-gray-200 text-xs focus:ring-1 focus:ring-agro-500 outline-none bg-white">
                    <option value="">Todos</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = \App\Models\Cliente::where('activo', true)->orderBy('nombre')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c->id); ?>"><?php echo e($c->nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
        </div>
    </div>

    
    <div class="space-y-2">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recorridos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden" wire:key="rec-<?php echo e($r->id); ?>">
                <button wire:click="toggleExpandir(<?php echo e($r->id); ?>)"
                    class="w-full text-left p-3.5 flex items-center justify-between hover:bg-gray-50 transition">
                    <div>
                        <div class="text-sm font-semibold text-gray-800">
                            <?php echo e($r->fecha_recorrido->format('d/m/Y')); ?>

                        </div>
                        <div class="flex flex-wrap gap-1 mt-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $r->tecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="text-2xs px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-500"><?php echo e($t->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="text-2xs text-gray-400 mt-1">
                            <?php echo e($r->visitas->count()); ?> parcela<?php echo e($r->visitas->count() !== 1 ? 's' : ''); ?>

                            · <?php echo e($r->visitas->where('tipo_visita', 'RECOMENDACION')->count()); ?> con recomendación
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 transition <?php echo e($recorridoExpandido === $r->id ? 'rotate-180' : ''); ?>"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recorridoExpandido === $r->id): ?>
                    <div class="border-t border-gray-50">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $r->visitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-3 pl-5 border-b border-gray-50 last:border-b-0">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0
                                        <?php echo e($v->tipo_visita === 'RECOMENDACION' ? 'bg-agro-500' : 'bg-gray-300'); ?>">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-gray-700"><?php echo e($v->parcela->nombre); ?></span>
                                            <span class="text-2xs px-1.5 py-0.5 rounded-full font-medium
                                                <?php echo e($v->tipo_visita === 'RECOMENDACION' ? 'bg-agro-50 text-agro-700' : 'bg-gray-100 text-gray-500'); ?>">
                                                <?php echo e($v->tipo_visita === 'RECOMENDACION' ? 'Recom.' : 'Monitoreo'); ?>

                                            </span>
                                        </div>
                                        <div class="text-2xs text-gray-400 mt-0.5"><?php echo e($v->cliente->nombre); ?></div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($v->tipo_visita === 'RECOMENDACION' && $v->recomendacion && $v->recomendacion->productosRecomendados->isNotEmpty()): ?>
                                            <div class="flex flex-wrap gap-1 mt-1.5">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $v->recomendacion->productosRecomendados->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="text-2xs px-1.5 py-0.5 rounded-full
                                                        <?php echo e($pr->producto->categoria === 'HERBICIDA' ? 'bg-green-50 text-green-700' : ''); ?>

                                                        <?php echo e($pr->producto->categoria === 'INSECTICIDA' ? 'bg-orange-50 text-orange-700' : ''); ?>

                                                        <?php echo e($pr->producto->categoria === 'FUNGICIDA' ? 'bg-blue-50 text-blue-700' : ''); ?>

                                                        <?php echo e(!in_array($pr->producto->categoria, ['HERBICIDA','INSECTICIDA','FUNGICIDA']) ? 'bg-gray-50 text-gray-600' : ''); ?>">
                                                        <?php echo e($pr->producto->nombre); ?>

                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($v->recomendacion->productosRecomendados->count() > 3): ?>
                                                    <span class="text-2xs text-gray-400">+<?php echo e($v->recomendacion->productosRecomendados->count() - 3); ?> más</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($v->observacion_productor): ?>
                                            <p class="text-2xs text-gray-400 italic mt-1 truncate"><?php echo e($v->observacion_productor); ?></p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="flex gap-2 mt-1.5">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($v->recomendacion): ?>
                                                <a href="<?php echo e(route('pdf.recomendacion', $v->id)); ?>" target="_blank"
                                                    class="text-2xs text-agro-600 hover:text-agro-700 font-medium">
                                                    📄 PDF
                                                </a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-10 text-gray-400 text-sm">
                No hay recorridos registrados aún.
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php /**PATH C:\2023\APPs\agrotrack-1\resources\views\livewire\campo\lista-recorridos.blade.php ENDPATH**/ ?>