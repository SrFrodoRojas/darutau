<?php

namespace App\Services;

use App\Models\DepositoProducto;
use App\Models\StockMovimiento;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockService
{
    /**
     * Incrementar stock (entrada)
     *
     * @param int $productoId
     * @param int $depositoId
     * @param int $cantidad (positiva)
     * @param string $referenciaTipo (ej. 'compra', 'ajuste', 'devolucion_venta')
     * @param int|null $referenciaId (ID de la compra, venta, etc.)
     * @param string|null $notas
     * @param int|null $usuarioId (si es null, usa Auth::id())
     * @param string $tipoMovimiento (por defecto 'compra', se puede sobrescribir)
     * @return DepositoProducto
     * @throws Exception
     */
    public function increment(
        $productoId,
        $depositoId,
        $cantidad,
        $referenciaTipo,
        $referenciaId,
        $notas = null,
        $usuarioId = null,
        $tipoMovimiento = 'compra'
    ) {
        if ($cantidad <= 0) {
            throw new Exception('La cantidad debe ser positiva.');
        }

        DB::beginTransaction();
        try {
            $depositoProducto = DepositoProducto::firstOrNew([
                'deposito_id' => $depositoId,
                'producto_id' => $productoId,
            ]);
            $stockAnterior = $depositoProducto->stock ?? 0;
            $depositoProducto->stock = $stockAnterior + $cantidad;
            $depositoProducto->save();

            StockMovimiento::create([
                'producto_id' => $productoId,
                'deposito_id' => $depositoId,
                'tipo' => $tipoMovimiento,
                'referencia_tipo' => $referenciaTipo,
                'referencia_id' => $referenciaId,
                'cantidad' => $cantidad,
                'stock_prev' => $stockAnterior,
                'stock_post' => $depositoProducto->stock,
                'usuario_id' => $usuarioId ?? Auth::id(),
                'notas' => $notas,
            ]);

            DB::commit();
            return $depositoProducto;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error al incrementar stock: ' . $e->getMessage());
        }
    }

    /**
     * Decrementar stock (salida)
     *
     * @param int $productoId
     * @param int $depositoId
     * @param int $cantidad (positiva)
     * @param string $referenciaTipo (ej. 'venta', 'ajuste', 'devolucion_compra')
     * @param int|null $referenciaId
     * @param string|null $notas
     * @param int|null $usuarioId
     * @param string $tipoMovimiento (por defecto 'venta')
     * @return DepositoProducto
     * @throws Exception
     */
    public function decrement(
        $productoId,
        $depositoId,
        $cantidad,
        $referenciaTipo,
        $referenciaId,
        $notas = null,
        $usuarioId = null,
        $tipoMovimiento = 'venta'
    ) {
        if ($cantidad <= 0) {
            throw new Exception('La cantidad debe ser positiva.');
        }

        $depositoProducto = DepositoProducto::where('deposito_id', $depositoId)
            ->where('producto_id', $productoId)
            ->first();

        if (!$depositoProducto || $depositoProducto->stock < $cantidad) {
            throw new Exception('Stock insuficiente en el depósito.');
        }

        DB::beginTransaction();
        try {
            $stockAnterior = $depositoProducto->stock;
            $depositoProducto->stock = $stockAnterior - $cantidad;
            $depositoProducto->save();

            StockMovimiento::create([
                'producto_id' => $productoId,
                'deposito_id' => $depositoId,
                'tipo' => $tipoMovimiento,
                'referencia_tipo' => $referenciaTipo,
                'referencia_id' => $referenciaId,
                'cantidad' => -$cantidad,
                'stock_prev' => $stockAnterior,
                'stock_post' => $depositoProducto->stock,
                'usuario_id' => $usuarioId ?? Auth::id(),
                'notas' => $notas,
            ]);

            DB::commit();
            return $depositoProducto;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error al decrementar stock: ' . $e->getMessage());
        }
    }

    /**
     * Ajuste manual de stock (puede ser positivo o negativo)
     *
     * @param int $productoId
     * @param int $depositoId
     * @param int $cantidad (puede ser positiva o negativa)
     * @param string $motivo (se guarda en notas)
     * @param int|null $usuarioId
     * @return DepositoProducto
     * @throws Exception
     */
    public function ajusteManual($productoId, $depositoId, $cantidad, $motivo, $usuarioId = null)
    {
        if ($cantidad == 0) {
            throw new Exception('La cantidad no puede ser cero.');
        }

        if ($cantidad > 0) {
            return $this->increment(
                $productoId,
                $depositoId,
                $cantidad,
                'ajuste',
                null,
                $motivo,
                $usuarioId,
                'ajuste'
            );
        } else {
            return $this->decrement(
                $productoId,
                $depositoId,
                abs($cantidad),
                'ajuste',
                null,
                $motivo,
                $usuarioId,
                'ajuste'
            );
        }
    }

    /**
     * Verificar disponibilidad (stock - stock_reservado)
     *
     * @param int $productoId
     * @param int $depositoId
     * @param int $cantidadNecesaria
     * @return bool
     */
    public function verificarDisponibilidad($productoId, $depositoId, $cantidadNecesaria)
    {
        $dp = DepositoProducto::where('deposito_id', $depositoId)
            ->where('producto_id', $productoId)
            ->first();

        if (!$dp) {
            return false;
        }
        $disponible = $dp->stock - $dp->stock_reservado;
        return $disponible >= $cantidadNecesaria;
    }
}
