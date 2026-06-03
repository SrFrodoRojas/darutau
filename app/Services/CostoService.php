<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\CostoHistorial;
use Illuminate\Support\Facades\Auth;

class CostoService
{
    /**
     * Actualiza el costo promedio ponderado y registra historial.
     *
     * @param int $productoId
     * @param int $nuevoCostoFob
     * @param int $nuevoCostoCif
     * @param int $cantidadComprada
     * @param int|null $compraDetalleId
     * @param string|null $motivo
     * @param int|null $usuarioId
     * @return Producto
     */
    public function actualizarCostoPromedio(
        $productoId,
        $nuevoCostoFob,
        $nuevoCostoCif,
        $cantidadComprada,
        $compraDetalleId = null,
        $motivo = null,
        $usuarioId = null
    ) {
        $producto = Producto::findOrFail($productoId);

        $costoAnteriorFob = $producto->costo_promedio_fob ?? 0;
        $costoAnteriorCif = $producto->costo_promedio_cif ?? 0;
        $stockActual = $producto->depositoProductos()->sum('stock'); // stock total en todos depósitos

        // Calcular nuevo promedio ponderado
        $valorAnteriorFob = $costoAnteriorFob * $stockActual;
        $valorNuevoFob = $nuevoCostoFob * $cantidadComprada;
        $nuevoStockTotal = $stockActual + $cantidadComprada;
        $nuevoPromedioFob = ($valorAnteriorFob + $valorNuevoFob) / $nuevoStockTotal;

        $valorAnteriorCif = $costoAnteriorCif * $stockActual;
        $valorNuevoCif = $nuevoCostoCif * $cantidadComprada;
        $nuevoPromedioCif = ($valorAnteriorCif + $valorNuevoCif) / $nuevoStockTotal;

        // Guardar historial antes de actualizar
        CostoHistorial::create([
            'producto_id' => $productoId,
            'fecha_cambio' => now(),
            'costo_anterior' => $costoAnteriorFob,
            'costo_nuevo' => $nuevoPromedioFob,
            'compra_detalle_id' => $compraDetalleId,
            'usuario_id' => $usuarioId ?? Auth::id(),
            'motivo' => $motivo ?? 'Actualización por compra',
        ]);

        $producto->costo_promedio_fob = $nuevoPromedioFob;
        $producto->costo_promedio_cif = $nuevoPromedioCif;
        $producto->ultimo_costo_fob = $nuevoCostoFob;
        $producto->ultimo_costo_cif = $nuevoCostoCif;
        $producto->save();

        return $producto;
    }
}
