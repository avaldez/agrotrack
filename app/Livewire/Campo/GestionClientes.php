<?php

namespace App\Livewire\Campo;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Parcela;
use App\Models\Cultivo;

class GestionClientes extends Component
{
    public $busqueda = '';
    public $mostrarFormulario = false;

    public $editando = false;
    public $clienteId = null;
    public $nombre = '';
    public $contacto = '';
    public $telefono = '';
    public $direccion = '';
    public $grupoWhatsapp = '';

    public $parcelaModal = false;
    public $parcelaClienteId = null;
    public $parcelaNombre = '';
    public $parcelaSuperficie = '';
    public $parcelaVariedad = '';
    public $parcelaCultivoId = '';

    public $cultivos = [];

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:150',
            'contacto' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:500',
            'grupoWhatsapp' => 'nullable|string|max:200',
        ];
    }

    public function mount()
    {
        $this->cultivos = Cultivo::where('activo', true)->orderBy('nombre')->get();
    }

    public function updatedBusqueda()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editando = false;
        $this->clienteId = null;
        $this->nombre = '';
        $this->contacto = '';
        $this->telefono = '';
        $this->direccion = '';
        $this->grupoWhatsapp = '';
        $this->mostrarFormulario = false;
    }

    public function editar($id)
    {
        $cliente = Cliente::findOrFail($id);
        $this->clienteId = $cliente->id;
        $this->nombre = $cliente->nombre;
        $this->contacto = $cliente->contacto;
        $this->telefono = $cliente->telefono;
        $this->direccion = $cliente->direccion;
        $this->grupoWhatsapp = $cliente->grupo_whatsapp;
        $this->editando = true;
        $this->mostrarFormulario = true;
    }

    public function guardar()
    {
        $this->validate();

        if ($this->editando && $this->clienteId) {
            $cliente = Cliente::findOrFail($this->clienteId);
            $cliente->update([
                'nombre' => $this->nombre,
                'contacto' => $this->contacto,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'grupo_whatsapp' => $this->grupoWhatsapp,
            ]);
            session()->flash('mensaje', 'Cliente actualizado correctamente.');
        } else {
            Cliente::create([
                'nombre' => $this->nombre,
                'contacto' => $this->contacto,
                'telefono' => $this->telefono,
                'direccion' => $this->direccion,
                'grupo_whatsapp' => $this->grupoWhatsapp,
                'creado_por_user_id' => auth()->id(),
            ]);
            session()->flash('mensaje', 'Cliente creado correctamente.');
        }

        $this->resetForm();
    }

    public function toggleActivo($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update(['activo' => !$cliente->activo]);
    }

    public function abrirParcelaModal($clienteId)
    {
        $this->parcelaClienteId = $clienteId;
        $this->parcelaModal = true;
        $this->parcelaNombre = '';
        $this->parcelaSuperficie = '';
        $this->parcelaVariedad = '';
        $this->parcelaCultivoId = '';
    }

    public function guardarParcela()
    {
        $this->validate([
            'parcelaNombre' => 'required|string|max:150',
            'parcelaSuperficie' => 'required|numeric|min:0',
            'parcelaVariedad' => 'nullable|string|max:100',
            'parcelaCultivoId' => 'nullable|exists:cultivos,id',
        ]);

        Parcela::create([
            'cliente_id' => $this->parcelaClienteId,
            'nombre' => $this->parcelaNombre,
            'superficie_ha' => $this->parcelaSuperficie,
            'variedad' => $this->parcelaVariedad,
            'cultivo_id' => $this->parcelaCultivoId ?: null,
        ]);

        $this->parcelaModal = false;
        session()->flash('mensaje', 'Parcela agregada correctamente.');
    }

    public function eliminarParcela($id)
    {
        Parcela::findOrFail($id)->delete();
    }

    public function getClientesProperty()
    {
        return Cliente::when($this->busqueda, function ($q) {
            $q->where('nombre', 'like', "%{$this->busqueda}%")
              ->orWhere('contacto', 'like', "%{$this->busqueda}%")
              ->orWhere('telefono', 'like', "%{$this->busqueda}%");
        })
        ->orderBy('nombre')
        ->withCount('parcelas')
        ->get();
    }

    public function render()
    {
        return view('livewire.campo.gestion-clientes', [
            'clientes' => $this->clientes,
        ])->layout('layouts.app');
    }
}
