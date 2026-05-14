<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitaParcela extends Model
{
    protected $fillable = [
        'recorrido_id', 'parcela_id', 'cliente_id', 'cultivo_id', 'zafra_id',
        'tipo_visita', 'estado_general', 'estado_plagas', 'estado_enfermedades',
        'estado_humedad', 'observacion_tecnico', 'observacion_productor',
        'tipo_aplicacion', 'variedad_observada', 'hectareas_aplicadas',
    ];

    protected function casts(): array
    {
        return [
            'hectareas_aplicadas' => 'decimal:2',
        ];
    }

    public function recorrido(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RecorridoTecnico::class, 'recorrido_id');
    }

    public function parcela(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Parcela::class);
    }

    public function cliente(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cultivo(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cultivo::class);
    }

    public function zafra(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Zafra::class);
    }

    public function recomendacion(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Recomendacion::class, 'visita_parcela_id');
    }

    public function esRecomendacion(): bool
    {
        return $this->tipo_visita === 'RECOMENDACION';
    }

    public function esMonitoreo(): bool
    {
        return $this->tipo_visita === 'MONITOREO';
    }

    public function getEstadoLabelAttribute(string $campo): string
    {
        $map = ['ok' => 'Sin novedad', 'warn' => 'Leve', 'bad' => 'Alta'];
        return $map[$this->{$campo}] ?? $this->{$campo};
    }
}
