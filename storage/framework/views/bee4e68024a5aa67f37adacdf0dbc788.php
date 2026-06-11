<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recomendación Técnica - AGROTRACK</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #1a1a1a; line-height: 1.5; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #1D9E75; padding-bottom: 15px; margin-bottom: 20px; }
        .logo h1 { font-size: 22px; color: #1D9E75; font-weight: 700; }
        .logo span { font-size: 11px; color: #666; }
        .titulo { font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
        .subtitulo { font-size: 11px; color: #666; margin-bottom: 15px; }
        .datos-cliente { background: #f8faf9; border-radius: 8px; padding: 14px; margin-bottom: 20px; }
        .datos-cliente table { width: 100%; border-collapse: collapse; }
        .datos-cliente td { padding: 4px 8px; font-size: 12px; }
        .datos-cliente td:first-child { font-weight: 600; color: #555; width: 120px; }
        .section-title { font-size: 13px; font-weight: 700; color: #1D9E75; border-bottom: 1px solid #e0e0e0; padding-bottom: 6px; margin-bottom: 10px; margin-top: 16px; }
        .estados { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 12px; }
        .estado-badge { padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .ok { background: #e1f5ee; color: #085041; }
        .warn { background: #faeeda; color: #633806; }
        .bad { background: #fcebeb; color: #a32d2d; }
        table.productos { width: 100%; border-collapse: collapse; margin-top: 8px; }
        table.productos th { background: #f0f0f0; padding: 6px 8px; text-align: left; font-size: 11px; font-weight: 600; color: #444; }
        table.productos td { padding: 5px 8px; border-bottom: 1px solid #eee; font-size: 11px; }
        .observacion { background: #fff8e6; border-left: 3px solid #ef9f27; padding: 10px 14px; margin: 12px 0; font-size: 12px; border-radius: 0 6px 6px 0; }
        .footer { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 12px; font-size: 10px; color: #999; text-align: center; }
        .tecnicos { font-size: 11px; color: #555; margin-top: 8px; }
        .sin-recomendacion { background: #f5f5f5; padding: 20px; text-align: center; border-radius: 8px; font-size: 14px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h1>AGROTRACK</h1>
            <span>Asistencia Técnica Agropecuaria</span>
        </div>
        <div style="text-align:right;font-size:11px;color:#666;">
            <div><?php echo e(now()->format('d/m/Y')); ?></div>
            <div style="margin-top:2px">Zafra: <?php echo e($visita->zafra?->nombre ?? '—'); ?></div>
        </div>
    </div>

    <div class="titulo">Informe de <?php echo e($visita->esRecomendacion() ? 'Recomendación' : 'Monitoreo'); ?></div>
    <div class="subtitulo">Recorrido del <?php echo e($visita->recorrido->fecha_recorrido->format('d/m/Y')); ?></div>

    <div class="datos-cliente">
        <table>
            <tr><td>Productor</td><td><?php echo e($visita->cliente->nombre); ?></td></tr>
            <tr><td>Parcela</td><td><?php echo e($visita->parcela->nombre); ?></td></tr>
            <tr><td>Cultivo</td><td><?php echo e($visita->cultivo?->nombre ?? $visita->variedad_observada ?? '—'); ?></td></tr>
            <tr><td>Superficie</td><td><?php echo e(number_format($visita->parcela->superficie_ha, 1)); ?> ha</td></tr>
            <tr><td>Variedad</td><td><?php echo e($visita->variedad_observada ?? $visita->parcela->variedad ?? '—'); ?></td></tr>
        </table>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($visita->esRecomendacion() && $recomendacion && $recomendacion->titulo): ?>
        <div class="section-title">Diagnóstico</div>
        <p style="font-size:12px;margin-bottom:10px;"><?php echo e($recomendacion->titulo); ?></p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="section-title">Estado del Cultivo</div>
    <div class="estados">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['general'=>'General','plagas'=>'Plagas','enfermedades'=>'Enfermedades','humedad'=>'Humedad']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="estado-badge <?php echo e($visita->{$k}); ?>">
                <?php echo e($lbl); ?>:
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($visita->{$k}):
                    case ('ok'): ?> Sin novedad <?php break; ?>
                    <?php case ('warn'): ?> Presencia leve <?php break; ?>
                    <?php case ('bad'): ?> Presencia alta <?php break; ?>
                <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($visita->esRecomendacion() && $recomendacion && $recomendacion->productosRecomendados->isNotEmpty()): ?>
        <div class="section-title">Productos Recomendados</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $productosPorCategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="margin-top:6px;">
                <div style="font-weight:600;font-size:11px;color:#555;margin-bottom:3px;"><?php echo e($categoria); ?></div>
                <table class="productos">
                    <thead>
                        <tr>
                            <th style="width:50%">Producto</th>
                            <th style="width:20%">Dosis</th>
                            <th style="width:15%">Unidad</th>
                            <th style="width:15%;text-align:right">Total ha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($pr->producto->nombre); ?></td>
                                <td><?php echo e(number_format($pr->dosis, 3, ',', '.')); ?></td>
                                <td><?php echo e($pr->producto->unidad); ?></td>
                                <td style="text-align:right"><?php echo e(number_format($pr->dosis, 3, ',', '.')); ?> <?php echo e($pr->producto->unidad); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($visita->esRecomendacion() && $recomendacion && $recomendacion->sin_recomendacion_motivo): ?>
        <div class="section-title">Motivo</div>
        <div class="observacion"><?php echo e($recomendacion->sin_recomendacion_motivo); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$visita->esRecomendacion() && $recomendacion && $recomendacion->sin_recomendacion_motivo): ?>
        <div class="section-title">Observación de la Visita</div>
        <div class="observacion"><?php echo e($recomendacion->sin_recomendacion_motivo); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($visita->observacion_productor): ?>
        <div class="section-title">Notas para el Productor</div>
        <div class="observacion"><?php echo e($visita->observacion_productor); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($visita->tipo_aplicacion): ?>
        <div style="margin-top:12px;font-size:12px;">
            <strong>Tipo de aplicación:</strong> <?php echo e($visita->tipo_aplicacion); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($visita->hectareas_aplicadas): ?>
                · <strong>Hectáreas:</strong> <?php echo e(number_format($visita->hectareas_aplicadas, 1, ',', '.')); ?> ha
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($visita->recorrido->tecnicos->isNotEmpty()): ?>
        <div class="tecnicos">
            <strong>Técnicos responsables:</strong>
            <?php echo e($visita->recorrido->tecnicos->pluck('name')->implode(' · ')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div class="footer">
        AGROTRACK — Sistema de Asistencia Técnica Agropecuaria
        <br>Documento generado el <?php echo e(now()->format('d/m/Y H:i')); ?>

    </div>
</body>
</html>
<?php /**PATH C:\2023\APPs\agrotrack-1\resources\views\pdf\recomendacion.blade.php ENDPATH**/ ?>