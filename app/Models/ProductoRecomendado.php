<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoRecomendado extends Model
{
    protected $fillable = [
        'recomendacion_id', 'producto_id', 'dosis', 'costo_unitario',
    ];

    protected function casts(): array
    {
        return [
            'dosis' => 'decimal:3',
            'costo_unitario' => 'decimal:2',
        ];
    }

    public function recomendacion(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Recomendacion::class);
    }

    public function producto(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function getCostoLineaAttribute(): float
    {
        return round($this->dosis * $this->costo_unitario, 2);
    }

    public function getPresentacionAttribute(): string
    {
        return "{$this->dosis} {$this->producto->unidad}";
    }
}
