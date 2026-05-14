<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Zafra;

class GestionZafras extends Component
{
    public $busqueda = '';
    public $mostrarFormulario = false;
    public $editando = false;
    public $zafraId = null;

    public $nombre = '';
    public $fecha_inicio = '';
    public $fecha_fin = '';

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:100',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ];
    }

    public function updatedBusqueda()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editando = false;
        $this->zafraId = null;
        $this->nombre = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->mostrarFormulario = false;
    }

    public function editar($id)
    {
        $z = Zafra::findOrFail($id);
        $this->zafraId = $z->id;
        $this->nombre = $z->nombre;
        $this->fecha_inicio = $z->fecha_inicio->format('Y-m-d');
        $this->fecha_fin = $z->fecha_fin?->format('Y-m-d') ?? '';
        $this->editando = true;
        $this->mostrarFormulario = true;
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'nombre' => $this->nombre,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin ?: null,
        ];

        if ($this->editando && $this->zafraId) {
            Zafra::findOrFail($this->zafraId)->update($data);
            session()->flash('mensaje', 'Zafra actualizada correctamente.');
        } else {
            Zafra::create($data);
            session()->flash('mensaje', 'Zafra creada correctamente.');
        }

        $this->resetForm();
    }

    public function toggleActivo($id)
    {
        $z = Zafra::findOrFail($id);
        $z->update(['activa' => !$z->activa]);
    }

    public function getZafrasProperty()
    {
        return Zafra::when($this->busqueda, fn($q) => $q->where('nombre', 'like', "%{$this->busqueda}%"))
            ->orderByDesc('fecha_inicio')
            ->withCount('visitas')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.gestion-zafras', [
            'zafras' => $this->zafras,
        ])->layout('layouts.app');
    }
}
