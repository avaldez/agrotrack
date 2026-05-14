@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <div>
        <h2 class="text-lg font-bold text-gray-800">Inicio</h2>
        <p class="text-xs text-gray-400">{{ now()->format('l, d F Y') }}</p>
    </div>

    @livewire('estadisticas-inicio')
</div>
@endsection
