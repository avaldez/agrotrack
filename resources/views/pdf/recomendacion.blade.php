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
            <div>{{ now()->format('d/m/Y') }}</div>
            <div style="margin-top:2px">Zafra: {{ $visita->zafra?->nombre ?? '—' }}</div>
        </div>
    </div>

    <div class="titulo">Informe de {{ $visita->esRecomendacion() ? 'Recomendación' : 'Monitoreo' }}</div>
    <div class="subtitulo">Recorrido del {{ $visita->recorrido->fecha_recorrido->format('d/m/Y') }}</div>

    <div class="datos-cliente">
        <table>
            <tr><td>Productor</td><td>{{ $visita->cliente->nombre }}</td></tr>
            <tr><td>Parcela</td><td>{{ $visita->parcela->nombre }}</td></tr>
            <tr><td>Cultivo</td><td>{{ $visita->cultivo?->nombre ?? $visita->variedad_observada ?? '—' }}</td></tr>
            <tr><td>Superficie</td><td>{{ number_format($visita->parcela->superficie_ha, 1) }} ha</td></tr>
            <tr><td>Variedad</td><td>{{ $visita->variedad_observada ?? $visita->parcela->variedad ?? '—' }}</td></tr>
        </table>
    </div>

    @if($visita->esRecomendacion() && $recomendacion && $recomendacion->titulo)
        <div class="section-title">Diagnóstico</div>
        <p style="font-size:12px;margin-bottom:10px;">{{ $recomendacion->titulo }}</p>
    @endif

    <div class="section-title">Estado del Cultivo</div>
    <div class="estados">
        @foreach(['general'=>'General','plagas'=>'Plagas','enfermedades'=>'Enfermedades','humedad'=>'Humedad'] as $k=>$lbl)
            <span class="estado-badge {{ $visita->{$k} }}">
                {{ $lbl }}:
                @switch($visita->{$k})
                    @case('ok') Sin novedad @break
                    @case('warn') Presencia leve @break
                    @case('bad') Presencia alta @break
                @endswitch
            </span>
        @endforeach
    </div>

    @if($visita->esRecomendacion() && $recomendacion && $recomendacion->productosRecomendados->isNotEmpty())
        <div class="section-title">Productos Recomendados</div>
        @foreach($productosPorCategoria as $categoria => $items)
            <div style="margin-top:6px;">
                <div style="font-weight:600;font-size:11px;color:#555;margin-bottom:3px;">{{ $categoria }}</div>
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
                        @foreach($items as $pr)
                            <tr>
                                <td>{{ $pr->producto->nombre }}</td>
                                <td>{{ number_format($pr->dosis, 3, ',', '.') }}</td>
                                <td>{{ $pr->producto->unidad }}</td>
                                <td style="text-align:right">{{ number_format($pr->dosis, 3, ',', '.') }} {{ $pr->producto->unidad }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif

    @if($visita->esRecomendacion() && $recomendacion && $recomendacion->sin_recomendacion_motivo)
        <div class="section-title">Motivo</div>
        <div class="observacion">{{ $recomendacion->sin_recomendacion_motivo }}</div>
    @endif

    @if(!$visita->esRecomendacion() && $recomendacion && $recomendacion->sin_recomendacion_motivo)
        <div class="section-title">Observación de la Visita</div>
        <div class="observacion">{{ $recomendacion->sin_recomendacion_motivo }}</div>
    @endif

    @if($visita->observacion_productor)
        <div class="section-title">Notas para el Productor</div>
        <div class="observacion">{{ $visita->observacion_productor }}</div>
    @endif

    @if($visita->tipo_aplicacion)
        <div style="margin-top:12px;font-size:12px;">
            <strong>Tipo de aplicación:</strong> {{ $visita->tipo_aplicacion }}
            @if($visita->hectareas_aplicadas)
                · <strong>Hectáreas:</strong> {{ number_format($visita->hectareas_aplicadas, 1, ',', '.') }} ha
            @endif
        </div>
    @endif

    @if($visita->recorrido->tecnicos->isNotEmpty())
        <div class="tecnicos">
            <strong>Técnicos responsables:</strong>
            {{ $visita->recorrido->tecnicos->pluck('name')->implode(' · ') }}
        </div>
    @endif

    <div class="footer">
        AGROTRACK — Sistema de Asistencia Técnica Agropecuaria
        <br>Documento generado el {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
