<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $fillable = [
        'cliente_id', 'nombre', 'superficie_ha', 'variedad',
        'fecha_siembra', 'fecha_cosecha', 'cultivo_id', 'activo',
    ];

    protected function casts(): array
    {
        return [
            'superficie_ha' => 'decimal:2',
            'fecha_siembra' => 'date',
            'fecha_cosecha' => 'date',
            'activo' => 'boolean',
        ];
    }

    public function cliente(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cultivo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function visitas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VisitaParcela::class);
    }
}
