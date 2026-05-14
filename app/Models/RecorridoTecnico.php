<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecorridoTecnico extends Model
{
    protected $table = 'recorrido_tecnicos';

    protected $fillable = [
        'fecha_recorrido', 'creado_por_user_id', 'observacion_general', 'finalizado',
    ];

    protected function casts(): array
    {
        return [
            'fecha_recorrido' => 'date',
            'finalizado' => 'boolean',
        ];
    }

    public function creadoPor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'creado_por_user_id');
    }

    public function tecnicos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'recorrido_tecnico_user', 'recorrido_id', 'user_id');
    }

    public function visitas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VisitaParcela::class, 'recorrido_id');
    }
}
