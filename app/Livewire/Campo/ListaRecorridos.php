<?php

namespace App\Livewire\Campo;

use Livewire\Component;
use App\Models\RecorridoTecnico;
use App\Models\VisitaParcela;

class ListaRecorridos extends Component
{
    public $filtroFechaDesde = '';
    public $filtroFechaHasta = '';
    public $filtroTecnico = '';
    public $filtroCliente = '';

    public $tecnicosList = [];
    public $recorridoExpandido = null;
    public $resumen = [];

    public function mount()
    {
        $this->tecnicosList = \App\Models\User::where('activo', true)
            ->whereIn('role', ['Admin', 'Tecnico'])
            ->orderBy('name')
            ->get();
    }

    public function toggleExpandir($id)
    {
        $this->recorridoExpandido = $this->recorridoExpandido === $id ? null : $id;
    }

    public function getRecorridosProperty()
    {
        return RecorridoTecnico::with(['tecnicos', 'visitas.parcela', 'visitas.cliente', 'visitas.recomendacion'])
            ->when($this->filtroFechaDesde, fn($q) => $q->whereDate('fecha_recorrido', '>=', $this->filtroFechaDesde))
            ->when($this->filtroFechaHasta, fn($q) => $q->whereDate('fecha_recorrido', '<=', $this->filtroFechaHasta))
            ->when($this->filtroTecnico, function ($q) {
                $q->whereHas('tecnicos', fn($sq) => $sq->where('user_id', $this->filtroTecnico));
            })
            ->when($this->filtroCliente, function ($q) {
                $q->whereHas('visitas', fn($sq) => $sq->where('cliente_id', $this->filtroCliente));
            })
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.campo.lista-recorridos', [
            'recorridos' => $this->recorridos,
        ])->layout('layouts.app');
    }
}
