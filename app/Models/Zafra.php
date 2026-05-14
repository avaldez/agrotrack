<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zafra extends Model
{
    protected $fillable = [
        'nombre', 'fecha_inicio', 'fecha_fin', 'activa',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'activa' => 'boolean',
        ];
    }

    public function visitas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VisitaParcela::class);
    }
}
