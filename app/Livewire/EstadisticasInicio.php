<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\RecorridoTecnico;
use App\Models\VisitaParcela;
use Illuminate\Support\Facades\DB;

class EstadisticasInicio extends Component
{
    public $totalClientes = 0;
    public $totalRecorridos = 0;
    public $ultimoRecorrido = null;
    public $proximasVisitas = [];

    public function mount()
    {
        $this->totalClientes = Cliente::where('activo', true)->count();
        $this->totalRecorridos = RecorridoTecnico::count();

        $this->ultimoRecorrido = RecorridoTecnico::with('tecnicos')
            ->latest()
            ->first();

        $this->proximasVisitas = VisitaParcela::with(['parcela', 'cliente'])
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.estadisticas-inicio');
    }
}
