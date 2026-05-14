<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recomendacion extends Model
{
    protected $fillable = [
        'visita_parcela_id', 'titulo', 'audio_url',
        'fecha_recomendacion', 'sin_recomendacion_motivo', 'requiere_accion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_recomendacion' => 'date',
            'requiere_accion' => 'boolean',
        ];
    }

    public function visitaParcela(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VisitaParcela::class);
    }

    public function productosRecomendados(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductoRecomendado::class);
    }

    public function getCostoTotalPorHaAttribute(): float
    {
        return round($this->productosRecomendados->sum(fn($p) => $p->dosis * $p->costo_unitario), 2);
    }

    public function getProductosAgrupadosAttribute(): \Illuminate\Support\Collection
    {
        return $this->productosRecomendados->load('producto')
            ->groupBy(fn($pr) => $pr->producto->categoria);
    }
}
