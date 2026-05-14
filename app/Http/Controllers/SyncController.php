<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitaParcela;
use App\Models\Recomendacion;
use App\Models\RecorridoTecnico;
use App\Models\ProductoRecomendado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    public function syncVisita(Request $request)
    {
        $data = $request->validate([
            'recorrido_id' => 'nullable|integer',
            'fecha_recorrido' => 'required|date',
            'creado_por_user_id' => 'required|integer|exists:users,id',
            'tecnicos' => 'sometimes|array',
            'tecnicos.*' => 'integer|exists:users,id',
            'visitas' => 'required|array',
            'visitas.*.parcela_id' => 'required|integer|exists:parcelas,id',
            'visitas.*.cliente_id' => 'required|integer|exists:clientes,id',
            'visitas.*.cultivo_id' => 'nullable|integer|exists:cultivos,id',
            'visitas.*.zafra_id' => 'nullable|integer|exists:zafras,id',
            'visitas.*.tipo_visita' => 'required|in:RECOMENDACION,MONITOREO',
            'visitas.*.estado_general' => 'in:ok,warn,bad',
            'visitas.*.estado_plagas' => 'in:ok,warn,bad',
            'visitas.*.estado_enfermedades' => 'in:ok,warn,bad',
            'visitas.*.estado_humedad' => 'in:ok,warn,bad',
            'visitas.*.observacion_tecnico' => 'nullable|string',
            'visitas.*.observacion_productor' => 'nullable|string',
            'visitas.*.tipo_aplicacion' => 'nullable|string',
            'visitas.*.variedad_observada' => 'nullable|string',
            'visitas.*.hectareas_aplicadas' => 'nullable|numeric',
            'visitas.*.sin_recomendacion_motivo' => 'nullable|string',
            'visitas.*.productos' => 'sometimes|array',
            'visitas.*.productos.*.producto_id' => 'required|integer|exists:productos,id',
            'visitas.*.productos.*.dosis' => 'required|numeric',
            'visitas.*.productos.*.costo_unitario' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $recorrido = RecorridoTecnico::updateOrCreate(
                ['id' => $data['recorrido_id'] ?? null],
                [
                    'fecha_recorrido' => $data['fecha_recorrido'],
                    'creado_por_user_id' => $data['creado_por_user_id'],
                    'finalizado' => true,
                ]
            );

            if (!empty($data['tecnicos'])) {
                $recorrido->tecnicos()->sync($data['tecnicos']);
            } else {
                $recorrido->tecnicos()->sync([$data['creado_por_user_id']]);
            }

            foreach ($data['visitas'] as $v) {
                $visita = VisitaParcela::create([
                    'recorrido_id' => $recorrido->id,
                    'parcela_id' => $v['parcela_id'],
                    'cliente_id' => $v['cliente_id'],
                    'cultivo_id' => $v['cultivo_id'] ?? null,
                    'zafra_id' => $v['zafra_id'] ?? null,
                    'tipo_visita' => $v['tipo_visita'],
                    'estado_general' => $v['estado_general'] ?? 'ok',
                    'estado_plagas' => $v['estado_plagas'] ?? 'ok',
                    'estado_enfermedades' => $v['estado_enfermedades'] ?? 'ok',
                    'estado_humedad' => $v['estado_humedad'] ?? 'ok',
                    'observacion_tecnico' => $v['observacion_tecnico'] ?? null,
                    'observacion_productor' => $v['observacion_productor'] ?? null,
                    'tipo_aplicacion' => $v['tipo_aplicacion'] ?? null,
                    'variedad_observada' => $v['variedad_observada'] ?? null,
                    'hectareas_aplicadas' => $v['hectareas_aplicadas'] ?? null,
                ]);

                $rec = Recomendacion::create([
                    'visita_parcela_id' => $visita->id,
                    'fecha_recomendacion' => $data['fecha_recorrido'],
                    'sin_recomendacion_motivo' => $v['sin_recomendacion_motivo'] ?? null,
                    'requiere_accion' => $v['tipo_visita'] === 'RECOMENDACION',
                ]);

                if (!empty($v['productos'])) {
                    foreach ($v['productos'] as $pr) {
                        ProductoRecomendado::create([
                            'recomendacion_id' => $rec->id,
                            'producto_id' => $pr['producto_id'],
                            'dosis' => $pr['dosis'],
                            'costo_unitario' => $pr['costo_unitario'],
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'recorrido_id' => $recorrido->id,
                'message' => 'Sincronización completada exitosamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sync visita error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error al sincronizar: ' . $e->getMessage(),
            ], 500);
        }
    }
}
