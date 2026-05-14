<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cultivo extends Model
{
    protected $fillable = [
        'nombre', 'tipo', 'activo',
    ];

    protected function casts(): array
    {
        return ['activo' => 'boolean'];
    }

    public function parcelas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Parcela::class);
    }

    public function visitas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VisitaParcela::class);
    }
}
