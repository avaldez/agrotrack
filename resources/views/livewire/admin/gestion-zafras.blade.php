<div>
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('dashboard') }}" class="p-1.5 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Zafras / Campañas</h2>
            <p class="text-xs text-gray-400">Gestión de campañas agrícolas</p>
        </div>
        @if(!$mostrarFormulario && auth()->user()->puedeMutar())
            <button wire:click="$set('mostrarFormulario', true)"
                class="ml-auto text-xs px-3 py-1.5 rounded-lg bg-agro-500 text-white font-medium">
                + Nueva
            </button>
        @endif
    </div>

    @if(session('mensaje'))
        <div class="mb-4 p-3 bg-agro-50 border border-agro-200 rounded-xl text-sm text-agro-700">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- Buscador --}}
    <div class="mb-4">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="search" wire:model.live="busqueda" placeholder="Buscar zafra..."
                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
        </div>
    </div>

    {{-- Formulario --}}
    @if($mostrarFormulario)
        <div class="bg-white border border-gray-100 rounded-xl p-4 mb-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ $editando ? 'Editar' : 'Nueva' }} zafra</h3>
            <form wire:submit.prevent="guardar" class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nombre *</label>
                    <input type="text" wire:model="nombre" placeholder="Ej: Zafra 2025-2026"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    @error('nombre') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Fecha inicio *</label>
                        <input type="date" wire:model="fecha_inicio"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                        @error('fecha_inicio') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Fecha fin</label>
                        <input type="date" wire:model="fecha_fin"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                        @error('fecha_fin') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-agro-500 text-white font-medium rounded-xl text-sm hover:bg-agro-600 transition">
                        {{ $editando ? 'Actualizar' : 'Guardar' }}
                    </button>
                    <button type="button" wire:click="resetForm"
                        class="py-2.5 px-4 border border-gray-200 rounded-xl text-sm text-gray-500">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Lista --}}
    <div class="space-y-2">
        @forelse($zafras as $z)
            <div class="bg-white border border-gray-100 rounded-xl p-3.5">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-semibold text-gray-800">{{ $z->nombre }}</h3>
                            @if($z->activa)
                                <span class="text-2xs px-1.5 py-0.5 rounded-full bg-agro-50 text-agro-700">Activa</span>
                            @else
                                <span class="text-2xs px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-400">Inactiva</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            {{ $z->fecha_inicio->format('d/m/Y') }} — {{ $z->fecha_fin?->format('d/m/Y') ?? 'Sin fecha fin' }}
                        </div>
                        <div class="flex items-center gap-2 mt-1.5">
                            <span class="text-2xs px-2 py-0.5 rounded-full bg-blue-50 text-blue-700">
                                {{ $z->visitas_count }} visita{{ $z->visitas_count !== 1 ? 's' : '' }}
                            </span>
                        </div>
                    </div>
                    @if(auth()->user()->puedeMutar())
                        <div class="flex items-center gap-1 ml-2">
                            <button wire:click="editar({{ $z->id }})"
                                class="p-1.5 text-gray-300 hover:text-agro-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button wire:click="toggleActivo({{ $z->id }})"
                                class="p-1.5 text-gray-300 hover:text-{{ $z->activa ? 'red' : 'agro' }}-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M{{ $z->activa ? 'M6 18L18 6M6 6l12 12' : 'M12 4v16m8-8H4' }}"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-400 text-sm">
                {{ $busqueda ? 'Sin resultados para "' . $busqueda . '"' : 'No hay zafras registradas.' }}
            </div>
        @endforelse
    </div>
</div>
