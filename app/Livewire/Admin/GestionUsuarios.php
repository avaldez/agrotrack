<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GestionUsuarios extends Component
{
    public $usuarios;
    public $mostrarForm = false;
    public $editandoId = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role = 'Tecnico';
    public $telefono = '';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|in:Admin,Tecnico,Consulta',
            'telefono' => 'nullable|string|max:20',
        ];

        if (!$this->editandoId) {
            $rules['email'] .= '|unique:users,email';
            $rules['password'] = 'required|min:6|confirmed';
        } else {
            $rules['email'] .= '|unique:users,email,' . $this->editandoId;
            $rules['password'] = 'nullable|min:6|confirmed';
        }

        return $rules;
    }

    public function mount()
    {
        $this->cargarUsuarios();
    }

    public function cargarUsuarios()
    {
        $this->usuarios = User::orderBy('name')->get();
    }

    public function resetForm()
    {
        $this->editandoId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'Tecnico';
        $this->telefono = '';
        $this->mostrarForm = false;
    }

    public function editar($id)
    {
        $u = User::findOrFail($id);
        $this->editandoId = $u->id;
        $this->name = $u->name;
        $this->email = $u->email;
        $this->role = $u->role;
        $this->telefono = $u->telefono;
        $this->mostrarForm = true;
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'telefono' => $this->telefono,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editandoId) {
            User::findOrFail($this->editandoId)->update($data);
            session()->flash('mensaje', 'Usuario actualizado.');
        } else {
            $data['password'] = Hash::make($this->password);
            User::create($data);
            session()->flash('mensaje', 'Usuario creado.');
        }

        $this->resetForm();
        $this->cargarUsuarios();
    }

    public function toggleActivo($id)
    {
        $u = User::findOrFail($id);
        $u->update(['activo' => !$u->activo]);
        $this->cargarUsuarios();
    }

    public function render()
    {
        return view('livewire.admin.gestion-usuarios');
    }
}
