<?php

namespace App\Livewire\Campo;

use Livewire\Component;
use App\Models\Producto;

class GestionProductos extends Component
{
    public $busqueda = '';
    public $categoriaFiltro = 'TODOS';
    public $mostrarFormulario = false;
    public $editando = false;
    public $productoId = null;

    public $nombre = '';
    public $categoria = 'HERBICIDA';
    public $unidad = 'L';
    public $dosis_referencia = '';
    public $precio_referencia = '';

    public $categorias = [
        'HERBICIDA', 'INSECTICIDA', 'FUNGICIDA',
        'FERTILIZANTE', 'ADHERENTE', 'SEMILLA', 'OTROS',
    ];

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:150',
            'categoria' => 'required|in:HERBICIDA,INSECTICIDA,FUNGICIDA,FERTILIZANTE,ADHERENTE,SEMILLA,OTROS',
            'unidad' => 'required|string|max:20',
            'dosis_referencia' => 'required|numeric|min:0',
            'precio_referencia' => 'required|numeric|min:0',
        ];
    }

    public function updatedBusqueda()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editando = false;
        $this->productoId = null;
        $this->nombre = '';
        $this->categoria = 'HERBICIDA';
        $this->unidad = 'L';
        $this->dosis_referencia = '';
        $this->precio_referencia = '';
        $this->mostrarFormulario = false;
    }

    public function editar($id)
    {
        $p = Producto::findOrFail($id);
        $this->productoId = $p->id;
        $this->nombre = $p->nombre;
        $this->categoria = $p->categoria;
        $this->unidad = $p->unidad;
        $this->dosis_referencia = $p->dosis_referencia;
        $this->precio_referencia = $p->precio_referencia;
        $this->editando = true;
        $this->mostrarFormulario = true;
    }

    public function guardar()
    {
        $this->validate();

        if ($this->editando && $this->productoId) {
            $p = Producto::findOrFail($this->productoId);
            $p->update([
                'nombre' => $this->nombre,
                'categoria' => $this->categoria,
                'unidad' => $this->unidad,
                'dosis_referencia' => $this->dosis_referencia,
                'precio_referencia' => $this->precio_referencia,
            ]);
            session()->flash('mensaje', 'Producto actualizado correctamente.');
        } else {
            Producto::create([
                'nombre' => $this->nombre,
                'categoria' => $this->categoria,
                'unidad' => $this->unidad,
                'dosis_referencia' => $this->dosis_referencia,
                'precio_referencia' => $this->precio_referencia,
            ]);
            session()->flash('mensaje', 'Producto creado correctamente.');
        }

        $this->resetForm();
    }

    public function toggleActivo($id)
    {
        $p = Producto::findOrFail($id);
        $p->update(['activo' => !$p->activo]);
    }

    public function getProductosProperty()
    {
        return Producto::where('activo', true)
            ->when($this->categoriaFiltro !== 'TODOS', fn($q) => $q->where('categoria', $this->categoriaFiltro))
            ->when($this->busqueda, fn($q) => $q->where('nombre', 'like', "%{$this->busqueda}%"))
            ->orderBy('nombre')
            ->get();
    }

    public function render()
    {
        return view('livewire.campo.gestion-productos', [
            'productos' => $this->productos,
        ])->layout('layouts.app');
    }
}
