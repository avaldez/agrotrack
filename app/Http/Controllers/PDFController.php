<?php

namespace App\Http\Controllers;

use App\Models\VisitaParcela;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    public function recomendacion(VisitaParcela $visita)
    {
        $visita->load([
            'parcela.cliente',
            'cultivo',
            'zafra',
            'recomendacion.productosRecomendados.producto',
            'recorrido.tecnicos',
        ]);

        $data = [
            'visita' => $visita,
            'recomendacion' => $visita->recomendacion,
            'productosPorCategoria' => $visita->recomendacion
                ? $visita->recomendacion->productosRecomendados
                    ->groupBy(fn($pr) => $pr->producto->categoria)
                : collect(),
        ];

        $pdf = Pdf::loadView('pdf.recomendacion', $data);
        $pdf->setPaper('A4');
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
        ]);

        $clienteNombre = str_replace(['/', '\\', ' '], '_', $visita->cliente->nombre);
        $parcelaNombre = str_replace(['/', '\\', ' '], '_', $visita->parcela->nombre);

        return $pdf->download(
            "recomendacion_{$clienteNombre}_{$parcelaNombre}.pdf"
        );
    }
}
