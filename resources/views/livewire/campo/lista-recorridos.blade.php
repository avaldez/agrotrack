<div>
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('dashboard') }}" class="p-2 -ml-2 text-gray-400 hover:text-gray-600 active:bg-gray-100 rounded-full transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Recorridos</h2>
            <p class="text-sm text-gray-400">Historial de visitas a campo</p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white border border-gray-100 rounded-xl p-4 mb-4 space-y-3 shadow-sm">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-xs font-medium text-gray-500 mb-2 block">Desde</label>
                <input type="date" wire:model.live="filtroFechaDesde"
                    class="w-full px-3 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none">
            </div>
            <div>
                <label class="text-xs font-medium text-gray-500 mb-2 block">Hasta</label>
                <input type="date" wire:model.live="filtroFechaHasta"
                    class="w-full px-3 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-xs font-medium text-gray-500 mb-2 block">Técnico</label>
                <select wire:model.live="filtroTecnico"
                    class="w-full px-3 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-white">
                    <option value="">Todos</option>
                    @foreach($tecnicosList as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs font-medium text-gray-500 mb-2 block">Cliente</label>
                <select wire:model.live="filtroCliente"
                    class="w-full px-3 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 outline-none bg-white">
                    <option value="">Todos</option>
                    @foreach(\App\Models\Cliente::where('activo', true)->orderBy('nombre')->get() as $c)
                        <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Lista de recorridos --}}
    <div class="space-y-3 pb-24">
        @forelse($recorridos as $r)
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm" wire:key="rec-{{ $r->id }}">
                <button wire:click="toggleExpandir({{ $r->id }})"
                    class="w-full text-left p-4 flex items-center justify-between hover:bg-gray-50 active:bg-gray-100 transition">
                    <div>
                        <div class="text-base font-bold text-gray-800">
                            {{ $r->fecha_recorrido->format('d/m/Y') }}
                        </div>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @foreach($r->tecnicos as $t)
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600 font-medium">{{ $t->name }}</span>
                            @endforeach
                        </div>
                        <div class="text-xs text-gray-400 mt-2 font-medium">
                            {{ $r->visitas->count() }} parcela{{ $r->visitas->count() !== 1 ? 's' : '' }}
                            · <span class="text-agro-600">{{ $r->visitas->where('tipo_visita', 'RECOMENDACION')->count() }} recomendadas</span>
                        </div>
                    </div>
                    <div class="p-2 bg-gray-50 rounded-full flex-shrink-0 ml-2">
                        <svg class="w-5 h-5 text-gray-400 transition {{ $recorridoExpandido === $r->id ? 'rotate-180' : '' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </button>

                @if($recorridoExpandido === $r->id)
                    <div class="border-t border-gray-100 bg-gray-50/50">
                        @foreach($r->visitas as $v)
                            <div class="p-4 pl-6 border-b border-gray-100 last:border-b-0">
                                <div class="flex items-start gap-3">
                                    <div class="w-2.5 h-2.5 rounded-full mt-1.5 flex-shrink-0 shadow-sm
                                        {{ $v->tipo_visita === 'RECOMENDACION' ? 'bg-agro-500' : 'bg-gray-300' }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-sm font-bold text-gray-800">{{ $v->parcela->nombre }}</span>
                                            <span class="text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-md font-bold
                                                {{ $v->tipo_visita === 'RECOMENDACION' ? 'bg-agro-100 text-agro-700' : 'bg-gray-200 text-gray-600' }}">
                                                {{ $v->tipo_visita === 'RECOMENDACION' ? 'Recom.' : 'Monitor' }}
                                            </span>
                                        </div>
                                        <div class="text-xs text-gray-500 mb-2">{{ $v->cliente->nombre }}</div>
                                        
                                        @if($v->tipo_visita === 'RECOMENDACION' && $v->recomendacion && $v->recomendacion->productosRecomendados->isNotEmpty())
                                            <div class="flex flex-wrap gap-1.5 mb-2">
                                                @foreach($v->recomendacion->productosRecomendados->take(3) as $pr)
                                                    <span class="text-xs px-2 py-1 rounded-lg border font-medium
                                                        {{ $pr->producto->categoria === 'HERBICIDA' ? 'bg-green-50 border-green-100 text-green-700' : '' }}
                                                        {{ $pr->producto->categoria === 'INSECTICIDA' ? 'bg-orange-50 border-orange-100 text-orange-700' : '' }}
                                                        {{ $pr->producto->categoria === 'FUNGICIDA' ? 'bg-blue-50 border-blue-100 text-blue-700' : '' }}
                                                        {{ !in_array($pr->producto->categoria, ['HERBICIDA','INSECTICIDA','FUNGICIDA']) ? 'bg-white border-gray-200 text-gray-600' : '' }}">
                                                        {{ $pr->producto->nombre }}
                                                    </span>
                                                @endforeach
                                                @if($v->recomendacion->productosRecomendados->count() > 3)
                                                    <span class="text-xs font-medium text-gray-400 py-1">+{{ $v->recomendacion->productosRecomendados->count() - 3 }} más</span>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        @if($v->observacion_productor)
                                            <p class="text-xs text-gray-500 italic mb-2 line-clamp-2 bg-white p-2 rounded-lg border border-gray-100">"{{ $v->observacion_productor }}"</p>
                                        @endif
                                        
                                        <div class="flex gap-2 mt-2">
                                            @if($v->recomendacion)
                                                <a href="{{ route('pdf.recomendacion', $v->id) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-agro-700 hover:bg-agro-50 active:bg-agro-100 transition shadow-sm">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                                                    Abrir PDF
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12 px-4 border-2 border-dashed border-gray-200 rounded-xl">
                <div class="text-4xl mb-3">🚜</div>
                <h3 class="text-base font-bold text-gray-700 mb-1">Sin recorridos</h3>
                <p class="text-sm text-gray-400">No se encontraron visitas registradas con estos filtros.</p>
            </div>
        @endforelse
    </div>
</div>
