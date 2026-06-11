<div>
    {{-- Encabezado --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('dashboard') }}" class="p-2 -ml-2 text-gray-400 hover:text-gray-600 active:bg-gray-100 rounded-full transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-xl font-bold text-gray-800">Nuevo recorrido</h2>
            <p class="text-sm text-gray-400">Registrá tu visita a campo</p>
        </div>
    </div>

    {{-- Mensajes --}}
    @if($mensajeExito)
        <div class="mb-4 p-4 bg-agro-50 border border-agro-200 rounded-xl text-base text-agro-700 flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ $mensajeExito }}
        </div>
    @endif

    @if($mensajeError)
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-base text-red-700 flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $mensajeError }}
        </div>
    @endif

    <form wire:submit.prevent="guardar" class="space-y-4 pb-28">
        {{-- Fecha y técnicos --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Fecha del recorrido</label>
                <input type="date" wire:model="fechaRecorrido"
                    class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none">
                @error('fechaRecorrido') <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Técnicos presentes</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($tecnicosDisponibles as $t)
                        <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full border text-sm cursor-pointer transition select-none
                            {{ in_array($t->id, $tecnicosSeleccionados) ? 'bg-agro-50 border-agro-500 text-agro-700 font-medium' : 'bg-white border-gray-200 text-gray-500' }}">
                            <input type="checkbox" value="{{ $t->id }}"
                                {{ in_array($t->id, $tecnicosSeleccionados) ? 'checked' : '' }}
                                wire:model="tecnicosSeleccionados" class="hidden">
                            {{ $t->name }}
                        </label>
                    @endforeach
                </div>
                @error('tecnicosSeleccionados') <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Cliente y parcela --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cliente / Productor</label>
                    <select wire:model.live="clienteId"
                        class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                        <option value="">Seleccionar cliente...</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                    @error('clienteId') <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Parcela</label>
                    <select wire:model="parcelaId"
                        class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                        <option value="">Seleccionar parcela...</option>
                        @foreach($parcelasDisponibles as $p)
                            <option value="{{ $p->id }}">{{ $p->nombre }} ({{ $p->superficie_ha }} ha)</option>
                        @endforeach
                    </select>
                    @error('parcelaId') <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Tipo de visita --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <label class="block text-sm font-medium text-gray-700 mb-3">Tipo de visita</label>
            <div class="grid grid-cols-2 gap-3">
                <button type="button" wire:click="$set('tipoVisita', 'MONITOREO')"
                    class="py-4 px-3 rounded-xl border text-sm font-medium transition text-center flex flex-col items-center gap-1
                    {{ $tipoVisita === 'MONITOREO' ? 'bg-agro-50 border-agro-500 text-agro-700 shadow-sm' : 'bg-white border-gray-200 text-gray-500 active:bg-gray-50' }}">
                    <div class="text-2xl">🔍</div>
                    Solo monitoreo
                </button>
                <button type="button" wire:click="$set('tipoVisita', 'RECOMENDACION')"
                    class="py-4 px-3 rounded-xl border text-sm font-medium transition text-center flex flex-col items-center gap-1
                    {{ $tipoVisita === 'RECOMENDACION' ? 'bg-agro-50 border-agro-500 text-agro-700 shadow-sm' : 'bg-white border-gray-200 text-gray-500 active:bg-gray-50' }}">
                    <div class="text-2xl">📋</div>
                    Con recomendación
                </button>
            </div>
        </div>

        {{-- Cultivo y variedad --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cultivo</label>
                    <select wire:model="cultivoId"
                        class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                        <option value="">—</option>
                        @foreach($cultivos as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Variedad</label>
                    <input type="text" wire:model="variedadObservada" placeholder="Ej: DM 66I68"
                        class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Zafra / Campaña</label>
                <select wire:model="zafraId"
                    class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                    <option value="">—</option>
                    @foreach($zafras as $z)
                        <option value="{{ $z->id }}">{{ $z->nombre }} ({{ $z->fecha_inicio->format('d/m/Y') }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Estados del cultivo --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
            <label class="block text-sm font-medium text-gray-700 mb-4">Estado observado del cultivo</label>
            <div class="space-y-4">
                @foreach([
                    'estadoGeneral' => 'General',
                    'estadoPlagas' => 'Plagas',
                    'estadoEnfermedades' => 'Enfermedades',
                    'estadoHumedad' => 'Humedad',
                ] as $campo => $label)
                    <div>
                        <span class="text-sm font-medium text-gray-500 mb-2 block">{{ $label }}</span>
                        <div class="flex gap-2">
                            @foreach(['ok' => '✅ Nulo/Leve', 'warn' => '⚠️ Moderado', 'bad' => '❌ Alto'] as $val => $txt)
                                <button type="button" wire:click="$set('{{ $campo }}', '{{ $val }}')"
                                    class="flex-1 py-3 px-1 rounded-xl border text-xs sm:text-sm font-medium transition text-center leading-tight
                                    {{ ${$campo} === $val ? ($val === 'ok' ? 'bg-agro-50 border-agro-500 text-agro-700 shadow-sm' : ($val === 'warn' ? 'bg-amber-50 border-amber-400 text-amber-700 shadow-sm' : 'bg-red-50 border-red-400 text-red-700 shadow-sm')) : 'bg-white border-gray-200 text-gray-400 active:bg-gray-50' }}">
                                    {{ $txt }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Productos (solo para RECOMENDACION) --}}
        @if($tipoVisita === 'RECOMENDACION')
            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <label class="text-sm font-medium text-gray-800">Productos para mezcla</label>
                    <button type="button" wire:click="addProducto"
                        class="text-sm px-4 py-2 rounded-lg bg-agro-50 text-agro-700 border border-agro-200 font-bold hover:bg-agro-100 active:bg-agro-200 transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Agregar
                    </button>
                </div>

                @error('productos') <span class="text-sm text-red-500 mb-3 block">{{ $message }}</span> @enderror

                @if(count($productos) === 0)
                    <div class="p-6 text-center border-2 border-dashed border-gray-200 rounded-xl">
                        <p class="text-sm text-gray-400">Tocá en "Agregar" para armar la mezcla de tanque de esta recomendación.</p>
                    </div>
                @endif

                <div class="space-y-4">
                    @foreach($productos as $index => $prod)
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 relative shadow-sm">
                            <button type="button" wire:click="removeProducto({{ $index }})"
                                class="absolute top-3 right-3 p-2 text-gray-400 hover:text-red-500 bg-white border border-gray-100 rounded-full shadow-sm active:scale-95 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            
                            <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Producto</label>
                            <select wire:model.live="productoSelect.{{ $index }}"
                                class="w-full pr-12 px-4 py-3.5 rounded-xl border border-gray-200 text-base font-medium text-gray-800 focus:ring-2 focus:ring-agro-500 outline-none bg-white mb-3">
                                <option value="">Seleccionar...</option>
                                @foreach($productosCatalogo as $pCat)
                                    <option value="{{ $pCat->id }}">{{ $pCat->nombre }} ({{ $pCat->categoria }})</option>
                                @endforeach
                            </select>
                            
                            @if($prod['producto_id'])
                                <div class="flex gap-3">
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-gray-500 mb-1.5 uppercase tracking-wide">Dosis ({{ $prod['unidad'] }}/ha)</label>
                                        <input type="number" step="0.01" inputmode="decimal" wire:model.live="productos.{{ $index }}.dosis"
                                            class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-lg font-bold text-center focus:ring-2 focus:ring-agro-500 outline-none bg-white shadow-inner"
                                            placeholder="0.00">
                                    </div>
                                    <div class="w-1/3 flex flex-col justify-end">
                                        <div class="w-full py-3.5 bg-white border border-gray-200 rounded-xl text-center">
                                            <span class="block text-[10px] text-gray-400 uppercase tracking-wide leading-none mb-1">Costo/ha</span>
                                            <span class="block text-sm font-bold text-agro-700 leading-none">${{ number_format($prod['costo'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Costo calculado (solo Admin y Técnico) --}}
                @if(auth()->user()->puedeMutar() && $totalCostoHa > 0)
                    <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center justify-between shadow-sm">
                        <span class="text-sm font-bold text-amber-800 flex items-center gap-2"><span class="text-xl">💰</span> Costo total aprox.</span>
                        <span class="text-lg font-black text-amber-900">${{ number_format($totalCostoHa, 2) }}/ha</span>
                    </div>
                @endif
            </div>
        @endif

        {{-- Observaciones --}}
        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm mb-8">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    🔒 Observación interna (solo técnico)
                </label>
                <textarea wire:model="observacionTecnico" rows="2"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none resize-none"
                    placeholder="Notas internas, historial..."></textarea>
            </div>
            @if($tipoVisita === 'RECOMENDACION')
                <div class="mb-4 border-t border-gray-100 pt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        💬 Observación para el productor
                    </label>
                    <textarea wire:model="observacionProductor" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none resize-none"
                        placeholder="Instrucciones de aplicación, clima, sugerencias..."></textarea>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de aplicación</label>
                        <select wire:model="tipoAplicacion"
                            class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none bg-white">
                            <option value="">Seleccionar tipo...</option>
                            <option>HERBICIDA</option>
                            <option>FUNGICIDA</option>
                            <option>INSECTICIDA</option>
                            <option>FERTILIZACIÓN</option>
                            <option>DESECACIÓN</option>
                            <option>COBERTURA</option>
                            <option>OTROS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Hectáreas aplicadas</label>
                        <input type="number" step="0.5" inputmode="decimal" wire:model="hectareasAplicadas"
                            class="w-full px-4 py-3.5 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none"
                            placeholder="Ej: 45.5">
                    </div>
                </div>
            @else
                <div class="border-t border-gray-100 pt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Motivo / observación general
                    </label>
                    <textarea wire:model="sinRecomendacionMotivo" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 text-base focus:ring-2 focus:ring-agro-500 focus:border-agro-500 outline-none resize-none"
                        placeholder="Todo en orden, cultivo sin novedades..."></textarea>
                </div>
            @endif
        </div>
        
        {{-- Acciones Sticky Bottom Bar (Float sobre menú) --}}
        <div class="fixed bottom-[65px] left-0 right-0 px-4 py-3 bg-white/95 backdrop-blur-sm border-t border-gray-200 z-30 flex flex-col sm:flex-row gap-3 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] max-w-xl mx-auto">
            @if($tipoVisita === 'RECOMENDACION' && count($productos) > 0)
                <button type="button" wire:click="generarMensajeWhatsApp"
                    class="w-full py-3.5 px-4 bg-[#25D366] text-white font-bold rounded-xl text-base hover:bg-[#128C7E] transition active:scale-[0.98] flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Compartir Reporte
                </button>
            @endif
            <button type="submit" wire:loading.attr="disabled"
                class="w-full py-3.5 bg-agro-500 text-white font-bold rounded-xl text-base hover:bg-agro-600 transition active:scale-[0.98] disabled:opacity-50 flex items-center justify-center gap-2">
                <span wire:loading.remove>💾 Guardar en base de datos</span>
                <span wire:loading>Guardando...</span>
            </button>
        </div>
    </form>

    {{-- Script offline sync --}}
    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('guardar-offline', async (event) => {
                const { data } = event;
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content || '';

                if (window.guardarVisitaOffline) {
                    await window.guardarVisitaOffline(data, csrf);
                }
            });

            Livewire.on('abrir-whatsapp', (event) => {
                window.open(event.url, '_blank');
            });
        });
    </script>
    @endpush
</div>
