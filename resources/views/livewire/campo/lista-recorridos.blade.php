<div>
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('dashboard') }}" class="p-1.5 -ml-1 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-lg font-bold text-gray-800">Recorridos</h2>
            <p class="text-xs text-gray-400">Historial de visitas a campo</p>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white border border-gray-100 rounded-xl p-3.5 mb-4 space-y-2">
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="text-2xs text-gray-500 mb-1 block">Desde</label>
                <input type="date" wire:model.live="filtroFechaDesde"
                    class="w-full px-2.5 py-2 rounded-lg border border-gray-200 text-xs focus:ring-1 focus:ring-agro-500 outline-none">
            </div>
            <div>
                <label class="text-2xs text-gray-500 mb-1 block">Hasta</label>
                <input type="date" wire:model.live="filtroFechaHasta"
                    class="w-full px-2.5 py-2 rounded-lg border border-gray-200 text-xs focus:ring-1 focus:ring-agro-500 outline-none">
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div>
                <label class="text-2xs text-gray-500 mb-1 block">Técnico</label>
                <select wire:model.live="filtroTecnico"
                    class="w-full px-2.5 py-2 rounded-lg border border-gray-200 text-xs focus:ring-1 focus:ring-agro-500 outline-none bg-white">
                    <option value="">Todos</option>
                    @foreach($tecnicosList as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-2xs text-gray-500 mb-1 block">Cliente</label>
                <select wire:model.live="filtroCliente"
                    class="w-full px-2.5 py-2 rounded-lg border border-gray-200 text-xs focus:ring-1 focus:ring-agro-500 outline-none bg-white">
                    <option value="">Todos</option>
                    @foreach(\App\Models\Cliente::where('activo', true)->orderBy('nombre')->get() as $c)
                        <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Lista de recorridos --}}
    <div class="space-y-2">
        @forelse($recorridos as $r)
            <div class="bg-white border border-gray-100 rounded-xl overflow-hidden" wire:key="rec-{{ $r->id }}">
                <button wire:click="toggleExpandir({{ $r->id }})"
                    class="w-full text-left p-3.5 flex items-center justify-between hover:bg-gray-50 transition">
                    <div>
                        <div class="text-sm font-semibold text-gray-800">
                            {{ $r->fecha_recorrido->format('d/m/Y') }}
                        </div>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($r->tecnicos as $t)
                                <span class="text-2xs px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-500">{{ $t->name }}</span>
                            @endforeach
                        </div>
                        <div class="text-2xs text-gray-400 mt-1">
                            {{ $r->visitas->count() }} parcela{{ $r->visitas->count() !== 1 ? 's' : '' }}
                            · {{ $r->visitas->where('tipo_visita', 'RECOMENDACION')->count() }} con recomendación
                        </div>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 transition {{ $recorridoExpandido === $r->id ? 'rotate-180' : '' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                @if($recorridoExpandido === $r->id)
                    <div class="border-t border-gray-50">
                        @foreach($r->visitas as $v)
                            <div class="p-3 pl-5 border-b border-gray-50 last:border-b-0">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0
                                        {{ $v->tipo_visita === 'RECOMENDACION' ? 'bg-agro-500' : 'bg-gray-300' }}">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-gray-700">{{ $v->parcela->nombre }}</span>
                                            <span class="text-2xs px-1.5 py-0.5 rounded-full font-medium
                                                {{ $v->tipo_visita === 'RECOMENDACION' ? 'bg-agro-50 text-agro-700' : 'bg-gray-100 text-gray-500' }}">
                                                {{ $v->tipo_visita === 'RECOMENDACION' ? 'Recom.' : 'Monitoreo' }}
                                            </span>
                                        </div>
                                        <div class="text-2xs text-gray-400 mt-0.5">{{ $v->cliente->nombre }}</div>
                                        @if($v->tipo_visita === 'RECOMENDACION' && $v->recomendacion && $v->recomendacion->productosRecomendados->isNotEmpty())
                                            <div class="flex flex-wrap gap-1 mt-1.5">
                                                @foreach($v->recomendacion->productosRecomendados->take(3) as $pr)
                                                    <span class="text-2xs px-1.5 py-0.5 rounded-full
                                                        {{ $pr->producto->categoria === 'HERBICIDA' ? 'bg-green-50 text-green-700' : '' }}
                                                        {{ $pr->producto->categoria === 'INSECTICIDA' ? 'bg-orange-50 text-orange-700' : '' }}
                                                        {{ $pr->producto->categoria === 'FUNGICIDA' ? 'bg-blue-50 text-blue-700' : '' }}
                                                        {{ !in_array($pr->producto->categoria, ['HERBICIDA','INSECTICIDA','FUNGICIDA']) ? 'bg-gray-50 text-gray-600' : '' }}">
                                                        {{ $pr->producto->nombre }}
                                                    </span>
                                                @endforeach
                                                @if($v->recomendacion->productosRecomendados->count() > 3)
                                                    <span class="text-2xs text-gray-400">+{{ $v->recomendacion->productosRecomendados->count() - 3 }} más</span>
                                                @endif
                                            </div>
                                        @endif
                                        @if($v->observacion_productor)
                                            <p class="text-2xs text-gray-400 italic mt-1 truncate">{{ $v->observacion_productor }}</p>
                                        @endif
                                        <div class="flex gap-2 mt-1.5">
                                            @if($v->recomendacion)
                                                <a href="{{ route('pdf.recomendacion', $v->id) }}" target="_blank"
                                                    class="text-2xs text-agro-600 hover:text-agro-700 font-medium">
                                                    📄 PDF
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
            <div class="text-center py-10 text-gray-400 text-sm">
                No hay recorridos registrados aún.
            </div>
        @endforelse
    </div>
</div>
