<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'telefono', 'activo',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function isTecnico(): bool
    {
        return $this->role === 'Tecnico';
    }

    public function isConsulta(): bool
    {
        return $this->role === 'Consulta';
    }

    public function puedeMutar(): bool
    {
        return in_array($this->role, ['Admin', 'Tecnico']);
    }

    public function recorridos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(RecorridoTecnico::class, 'recorrido_tecnico_user', 'user_id', 'recorrido_id');
    }

    public function clientesCreados(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Cliente::class, 'creado_por_user_id');
    }

    public function recorridosCreados(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(RecorridoTecnico::class, 'creado_por_user_id');
    }
}
