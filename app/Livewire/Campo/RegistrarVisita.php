<?php

namespace App\Livewire\Campo;

use Livewire\Component;
use App\Models\Cliente;
use App\Models\Parcela;
use App\Models\Producto;
use App\Models\Cultivo;
use App\Models\Zafra;
use App\Models\RecorridoTecnico;
use App\Models\VisitaParcela;
use App\Models\Recomendacion;
use App\Models\ProductoRecomendado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegistrarVisita extends Component
{
    public $recorridoId = null;
    public $fechaRecorrido;
    public $observacionGeneral = '';
    public $tecnicosSeleccionados = [];
    public $tecnicosDisponibles = [];

    public $clienteId = '';
    public $parcelaId = '';
    public $parcelasDisponibles = [];

    public $tipoVisita = 'MONITOREO';
    public $cultivoId = '';
    public $zafraId = '';
    public $variedadObservada = '';
    public $hectareasAplicadas = '';

    public $estadoGeneral = 'ok';
    public $estadoPlagas = 'ok';
    public $estadoEnfermedades = 'ok';
    public $estadoHumedad = 'ok';

    public $observacionTecnico = '';
    public $observacionProductor = '';
    public $tipoAplicacion = '';

    public $sinRecomendacionMotivo = '';

    public $productos = [];
    public $productosCatalogo = [];
    public $productoSelect = [];

    public $clientes = [];
    public $cultivos = [];
    public $zafras = [];
    public $totalCostoHa = 0;

    public $guardando = false;
    public $mensajeExito = '';
    public $mensajeError = '';

    protected $listeners = ['clienteSelected', 'refreshComponent' => '$refresh'];

    protected function rules()
    {
        return [
            'fechaRecorrido' => 'required|date',
            'clienteId' => 'required|exists:clientes,id',
            'parcelaId' => 'required|exists:parcelas,id',
            'tipoVisita' => 'required|in:MONITOREO,RECOMENDACION',
            'estadoGeneral' => 'in:ok,warn,bad',
            'estadoPlagas' => 'in:ok,warn,bad',
            'estadoEnfermedades' => 'in:ok,warn,bad',
            'estadoHumedad' => 'in:ok,warn,bad',
            'observacionTecnico' => 'nullable|string|max:2000',
            'observacionProductor' => 'nullable|string|max:2000',
            'tipoAplicacion' => 'nullable|string|max:100',
            'variedadObservada' => 'nullable|string|max:100',
            'hectareasAplicadas' => 'nullable|numeric|min:0',
            'sinRecomendacionMotivo' => 'nullable|string|max:500',
            'tecnicosSeleccionados' => 'required|array|min:1',
        ];
    }

    public function mount($recorrido = null)
    {
        $this->fechaRecorrido = now()->format('Y-m-d');
        $this->tecnicosDisponibles = \App\Models\User::where('activo', true)
            ->whereIn('role', ['Admin', 'Tecnico'])
            ->get();
        $this->tecnicosSeleccionados = [auth()->id()];

        $this->clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $this->cultivos = Cultivo::where('activo', true)->orderBy('nombre')->get();
        $this->zafras = Zafra::where('activa', true)->orderByDesc('fecha_inicio')->get();
        $this->productosCatalogo = Producto::where('activo', true)->orderBy('nombre')->get();
        $this->productoSelect = array_fill(0, 10, '');

        if ($recorrido) {
            $this->recorridoId = $recorrido;
            $this->cargarRecorridoExistente($recorrido);
        }
    }

    public function updatedClienteId($value)
    {
        $this->parcelaId = '';
        $this->parcelasDisponibles = $value
            ? Parcela::where('cliente_id', $value)->where('activo', true)->orderBy('nombre')->get()
            : [];
    }

    public function updatedTipoVisita($value)
    {
        $this->resetProductos();
    }

    public function addProducto()
    {
        $this->productos[] = [
            'producto_id' => '',
            'nombre' => '',
            'dosis' => 0,
            'unidad' => 'L',
            'precio' => 0,
            'costo' => 0,
        ];
        $this->productoSelect[] = '';
    }

    public function removeProducto($index)
    {
        unset($this->productos[$index]);
        $this->productos = array_values($this->productos);
        unset($this->productoSelect[$index]);
        $this->productoSelect = array_values($this->productoSelect);
        $this->calcularCosto();
    }

    public function updatedProductoSelect($value, $index)
    {
        if (!$value) return;
        $producto = Producto::find($value);
        if (!$producto) return;

        if (!isset($this->productos[$index])) {
            $this->productos[$index] = [
                'producto_id' => '',
                'nombre' => '',
                'dosis' => 0,
                'unidad' => 'L',
                'precio' => 0,
                'costo' => 0,
            ];
        }

        $this->productos[$index]['producto_id'] = $producto->id;
        $this->productos[$index]['nombre'] = $producto->nombre;
        $this->productos[$index]['dosis'] = (float) $producto->dosis_referencia;
        $this->productos[$index]['unidad'] = $producto->unidad;
        $this->productos[$index]['precio'] = (float) $producto->precio_referencia;
        $this->productos[$index]['costo'] = round(
            (float) $producto->dosis_referencia * (float) $producto->precio_referencia, 2
        );
        $this->calcularCosto();
    }

    public function updatedProductos($value, $key)
    {
        $this->calcularCosto();
    }

    public function calcularCosto()
    {
        $this->totalCostoHa = round(
            array_sum(array_column($this->productos, 'costo')), 2
        );
    }

    public function resetProductos()
    {
        $this->productos = [];
        $this->productoSelect = [];
        $this->totalCostoHa = 0;
    }

    public function generarMensajeWhatsApp()
    {
        if (!$this->clienteId || !$this->parcelaId) return '';

        $cliente = Cliente::find($this->clienteId);
        $parcela = Parcela::find($this->parcelaId);

        $msg = "🧑‍🌾 *AGROTRACK - Informe de Visita*\n\n";
        $msg .= "📅 Fecha: {$this->fechaRecorrido}\n";
        $msg .= "👤 Productor: {$cliente->nombre}\n";
        $msg .= "🌱 Parcela: {$parcela->nombre}\n";
        if ($this->variedadObservada) $msg .= "🌾 Variedad: {$this->variedadObservada}\n";
        $msg .= "\n";

        $estados = [
            'General' => $this->estadoGeneral,
            'Plagas' => $this->estadoPlagas,
            'Enfermedades' => $this->estadoEnfermedades,
            'Humedad' => $this->estadoHumedad,
        ];
        $mapa = ['ok' => '✅ Sin novedad', 'warn' => '⚠️ Leve', 'bad' => '❌ Alta'];

        $msg .= "*Estado del cultivo:*\n";
        foreach ($estados as $k => $v) {
            $msg .= "{$k}: {$mapa[$v]}\n";
        }
        $msg .= "\n";

        if ($this->tipoVisita === 'RECOMENDACION' && count($this->productos) > 0) {
            $msg .= "*📋 Recomendación:*\n";
            $agrupados = collect($this->productos)->groupBy(function ($p) {
                $prod = Producto::find($p['producto_id']);
                return $prod?->categoria ?? 'OTROS';
            });
            foreach ($agrupados as $cat => $items) {
                $msg .= "┌─ *{$cat}*\n";
                foreach ($items as $item) {
                    $msg .= "│ • {$item['nombre']}: {$item['dosis']} {$item['unidad']}/ha\n";
                }
                $msg .= "└─\n";
            }
            if ($this->tipoAplicacion) {
                $msg .= "\n🔄 Tipo: {$this->tipoAplicacion}\n";
            }
            if ($this->hectareasAplicadas) {
                $msg .= "📐 Hectáreas: {$this->hectareasAplicadas} ha\n";
            }
        } else {
            $msg .= "*🔍 Monitoreo sin recomendación*\n";
        }

        if ($this->observacionProductor) {
            $msg .= "\n💬 *Nota:* {$this->observacionProductor}\n";
        }

        $msg .= "\n👥 Técnicos: " . \App\Models\User::whereIn('id', $this->tecnicosSeleccionados)
            ->pluck('name')->implode(', ');

        $msg .= "\n\n_Gracias por confiar en AGROTRACK 🌿_";

        $url = 'https://wa.me/?text=' . urlencode($msg);

        if (!request()->expectsJson()) {
            return $this->dispatchBrowserEvent('abrir-whatsapp', ['url' => $url]);
        }

        return $msg;
    }

    public function guardar()
    {
        $this->validate();

        if ($this->tipoVisita === 'RECOMENDACION' && count($this->productos) === 0) {
            $this->addError('productos', 'Debe agregar al menos un producto a la recomendación.');
            return;
        }

        $this->guardando = true;
        $this->mensajeExito = '';
        $this->mensajeError = '';

        try {
            DB::beginTransaction();

            $recorrido = RecorridoTecnico::updateOrCreate(
                ['id' => $this->recorridoId],
                [
                    'fecha_recorrido' => $this->fechaRecorrido,
                    'creado_por_user_id' => auth()->id(),
                    'observacion_general' => $this->observacionGeneral ?: null,
                    'finalizado' => true,
                ]
            );

            $recorrido->tecnicos()->sync($this->tecnicosSeleccionados);

            $visita = VisitaParcela::create([
                'recorrido_id' => $recorrido->id,
                'parcela_id' => $this->parcelaId,
                'cliente_id' => $this->clienteId,
                'cultivo_id' => $this->cultivoId ?: null,
                'zafra_id' => $this->zafraId ?: null,
                'tipo_visita' => $this->tipoVisita,
                'estado_general' => $this->estadoGeneral,
                'estado_plagas' => $this->estadoPlagas,
                'estado_enfermedades' => $this->estadoEnfermedades,
                'estado_humedad' => $this->estadoHumedad,
                'observacion_tecnico' => $this->observacionTecnico ?: null,
                'observacion_productor' => $this->observacionProductor ?: null,
                'tipo_aplicacion' => $this->tipoAplicacion ?: null,
                'variedad_observada' => $this->variedadObservada ?: null,
                'hectareas_aplicadas' => $this->hectareasAplicadas ?: null,
            ]);

            $rec = Recomendacion::create([
                'visita_parcela_id' => $visita->id,
                'fecha_recomendacion' => $this->fechaRecorrido,
                'sin_recomendacion_motivo' => $this->sinRecomendacionMotivo ?: null,
                'requiere_accion' => $this->tipoVisita === 'RECOMENDACION',
            ]);

            if ($this->tipoVisita === 'RECOMENDACION') {
                foreach ($this->productos as $p) {
                    if (!empty($p['producto_id'])) {
                        ProductoRecomendado::create([
                            'recomendacion_id' => $rec->id,
                            'producto_id' => $p['producto_id'],
                            'dosis' => $p['dosis'],
                            'costo_unitario' => $p['precio'],
                        ]);
                    }
                }
            }

            DB::commit();

            $this->mensajeExito = 'Visita guardada exitosamente.';
            $this->recorridoId = $recorrido->id;
            $this->guardando = false;

            $this->dispatchBrowserEvent('visita-guardada', [
                'recorrido_id' => $recorrido->id,
                'visita_id' => $visita->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error guardando visita: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);
            $this->mensajeError = 'Error al guardar: ' . $e->getMessage();
            $this->guardando = false;
        }
    }

    protected function guardarOffline()
    {
        $data = [
            'fecha_recorrido' => $this->fechaRecorrido,
            'creado_por_user_id' => auth()->id(),
            'tecnicos' => $this->tecnicosSeleccionados,
            'visitas' => [
                [
                    'parcela_id' => $this->parcelaId,
                    'cliente_id' => $this->clienteId,
                    'cultivo_id' => $this->cultivoId ?: null,
                    'zafra_id' => $this->zafraId ?: null,
                    'tipo_visita' => $this->tipoVisita,
                    'estado_general' => $this->estadoGeneral,
                    'estado_plagas' => $this->estadoPlagas,
                    'estado_enfermedades' => $this->estadoEnfermedades,
                    'estado_humedad' => $this->estadoHumedad,
                    'observacion_tecnico' => $this->observacionTecnico,
                    'observacion_productor' => $this->observacionProductor,
                    'tipo_aplicacion' => $this->tipoAplicacion,
                    'variedad_observada' => $this->variedadObservada,
                    'hectareas_aplicadas' => $this->hectareasAplicadas,
                    'sin_recomendacion_motivo' => $this->sinRecomendacionMotivo,
                    'productos' => collect($this->productos)->filter(fn($p) => !empty($p['producto_id']))->values()->toArray(),
                ],
            ],
        ];

        $this->dispatchBrowserEvent('guardar-offline', ['data' => $data]);
        $this->mensajeExito = 'Datos guardados localmente. Se sincronizarán automáticamente al recuperar conexión.';
        $this->guardando = false;
    }

    public function render()
    {
        return view('livewire.campo.registrar-visita')
            ->layout('layouts.app');
    }
}
