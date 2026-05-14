<div>
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('dashboard') }}" class="p-1.5 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Clientes</h2>
            <p class="text-xs text-gray-400">Productores y parcelas</p>
        </div>
        @if(!$mostrarFormulario && auth()->user()->puedeMutar())
            <button wire:click="$set('mostrarFormulario', true)"
                class="ml-auto text-xs px-3 py-1.5 rounded-lg bg-agro-500 text-white font-medium">
                + Nuevo
            </button>
        @endif
    </div>

    @if(session('mensaje'))
        <div class="mb-4 p-3 bg-agro-50 border border-agro-200 rounded-xl text-sm text-agro-700">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- Buscador reactivo --}}
    <div class="mb-4">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="search" wire:model.live="busqueda" placeholder="Buscar cliente..."
                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
        </div>
    </div>

    {{-- Formulario --}}
    @if($mostrarFormulario)
        <div class="bg-white border border-gray-100 rounded-xl p-4 mb-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">{{ $editando ? 'Editar' : 'Nuevo' }} cliente</h3>
            <form wire:submit.prevent="guardar" class="space-y-3">
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Nombre *</label>
                    <input type="text" wire:model="nombre"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    @error('nombre') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Contacto</label>
                        <input type="text" wire:model="contacto"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Teléfono</label>
                        <input type="text" wire:model="telefono"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    </div>
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Dirección</label>
                    <input type="text" wire:model="direccion"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                </div>
                <div>
                    <label class="text-xs text-gray-500 mb-1 block">Grupo WhatsApp</label>
                    <input type="text" wire:model="grupoWhatsapp" placeholder="Nombre o link del grupo"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
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

    {{-- Lista de clientes --}}
    <div class="space-y-2">
        @forelse($clientes as $c)
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden">
                <div class="p-3.5" wire:key="cliente-{{ $c->id }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-semibold text-gray-800">{{ $c->nombre }}</h3>
                                @if(!$c->activo)
                                    <span class="text-2xs px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-400">Inactivo</span>
                                @endif
                            </div>
                            @if($c->contacto || $c->telefono)
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $c->contacto ? "{$c->contacto}" : '' }}{{ $c->contacto && $c->telefono ? ' · ' : '' }}{{ $c->telefono ? "{$c->telefono}" : '' }}
                                </p>
                            @endif
                            <div class="flex items-center gap-2 mt-1.5">
                                <span class="text-2xs px-2 py-0.5 rounded-full bg-agro-50 text-agro-700">
                                    {{ $c->parcelas_count }} parcela{{ $c->parcelas_count !== 1 ? 's' : '' }}
                                </span>
                                @if($c->grupo_whatsapp)
                                    <span class="text-2xs px-2 py-0.5 rounded-full bg-green-50 text-green-700">WhatsApp</span>
                                @endif
                            </div>
                        </div>
                        @if(auth()->user()->puedeMutar())
                            <div class="flex items-center gap-1 ml-2">
                                <button wire:click="editar({{ $c->id }})"
                                    class="p-1.5 text-gray-300 hover:text-agro-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>

                    {{-- Parcelas del cliente --}}
                    @php $parcelas = $c->parcelas()->orderBy('nombre')->get(); @endphp
                    @if($parcelas->isNotEmpty())
                        <div class="mt-2.5 pt-2.5 border-t border-gray-50">
                            <div class="space-y-1.5">
                                @foreach($parcelas as $p)
                                    <div class="flex items-center justify-between text-xs text-gray-500 py-1 pl-2 border-l-2 border-agro-200">
                                        <div>
                                            <span class="font-medium text-gray-600">{{ $p->nombre }}</span>
                                            <span class="text-gray-400"> · {{ number_format($p->superficie_ha, 1) }} ha</span>
                                            @if($p->variedad)
                                                <span class="text-gray-400"> · {{ $p->variedad }}</span>
                                            @endif
                                        </div>
                                        @if(auth()->user()->puedeMutar())
                                            <button wire:click="eliminarParcela({{ $p->id }})"
                                                wire:confirm="¿Eliminar esta parcela?"
                                                class="text-gray-300 hover:text-red-500 transition p-0.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(auth()->user()->puedeMutar())
                        <button wire:click="abrirParcelaModal({{ $c->id }})"
                            class="mt-2 text-xs text-agro-600 hover:text-agro-700 font-medium">
                            + Agregar parcela
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-400 text-sm">
                {{ $busqueda ? 'Sin resultados para "' . $busqueda . '"' : 'No hay clientes registrados.' }}
            </div>
        @endforelse
    </div>

    {{-- Modal agregar parcela --}}
    @if($parcelaModal)
        <div class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-4 bg-black/40" wire:click.self="$set('parcelaModal', false)">
            <div class="bg-white rounded-2xl w-full max-w-sm p-5 animate-slide-up" wire:click.stop>
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Nueva parcela</h3>
                <form wire:submit.prevent="guardarParcela" class="space-y-3">
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Nombre *</label>
                        <input type="text" wire:model="parcelaNombre"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Superficie (ha) *</label>
                            <input type="number" step="0.1" wire:model="parcelaSuperficie"
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 mb-1 block">Cultivo</label>
                            <select wire:model="parcelaCultivoId"
                                class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none bg-white">
                                <option value="">—</option>
                                @foreach($cultivos as $c)
                                    <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 mb-1 block">Variedad</label>
                        <input type="text" wire:model="parcelaVariedad"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-agro-500 outline-none">
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                            class="flex-1 py-2.5 bg-agro-500 text-white font-medium rounded-xl text-sm hover:bg-agro-600 transition">
                            Guardar
                        </button>
                        <button type="button" wire:click="$set('parcelaModal', false)"
                            class="py-2.5 px-4 border border-gray-200 rounded-xl text-sm text-gray-500">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
