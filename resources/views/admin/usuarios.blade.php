@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('dashboard') }}" class="p-1.5 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Usuarios</h2>
            <p class="text-xs text-gray-400">Gestión de usuarios del sistema</p>
        </div>
    </div>

    @livewire('admin.gestion-usuarios')
</div>
@endsection
