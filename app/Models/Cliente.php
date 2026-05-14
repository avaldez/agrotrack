<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre', 'contacto', 'telefono', 'direccion',
        'grupo_whatsapp', 'creado_por_user_id', 'activo',
    ];

    protected function casts(): array
    {
        return ['activo' => 'boolean'];
    }

    public function parcelas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Parcela::class);
    }

    public function creadoPor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por_user_id');
    }

    public function visitas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VisitaParcela::class);
    }
}
