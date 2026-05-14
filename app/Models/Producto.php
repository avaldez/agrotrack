<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre', 'categoria', 'unidad',
        'dosis_referencia', 'precio_referencia', 'activo',
    ];

    protected function casts(): array
    {
        return [
            'dosis_referencia' => 'decimal:3',
            'precio_referencia' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    public function productosRecomendados(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductoRecomendado::class);
    }

    public function getCostoPorHaAttribute(): float
    {
        return round($this->dosis_referencia * $this->precio_referencia, 2);
    }

    public function scopeByCategoria($query, $categoria)
    {
        return $categoria ? $query->where('categoria', $categoria) : $query;
    }
}
