<?php

namespace App\Services;

use App\Models\Caja;
use App\Models\CajaMovimiento;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\DB;

class CajaService
{
    /**
     * Registrar un movimiento en la caja.
     *
     * @param Caja $caja
     * @param Usuario $usuario
     * @param string $tipo 'ingreso' o 'egreso'
     * @param string $concepto
     * @param int|null $categoriaMovimientoId
     * @param int $monto
     * @param string $moneda
     * @param int|null $metodoPagoId
     * @param string|null $referenciaTipo
     * @param int|null $referenciaId
     * @param string|null $comprobanteNumero
     * @param string|null $descripcion
     * @return CajaMovimiento
     * @throws Exception
     */
    public function registrarMovimiento(
        Caja $caja,
        Usuario $usuario,
        string $tipo,
        string $concepto,
        ?int $categoriaMovimientoId,
        int $monto,
        string $moneda = 'PYG',
        ?int $metodoPagoId = null,
        ?string $referenciaTipo = null,
        ?int $referenciaId = null,
        ?string $comprobanteNumero = null,
        ?string $descripcion = null
    ): CajaMovimiento {
        if ($caja->estado !== 'abierta') {
            throw new Exception('La caja no está abierta.');
        }

        if ($monto <= 0) {
            throw new Exception('El monto debe ser mayor a cero.');
        }

        $saldoActual = (int) $caja->saldo_actual;
        $nuevoSaldo = $tipo === 'ingreso' ? $saldoActual + $monto : $saldoActual - $monto;

        if ($tipo === 'egreso' && $nuevoSaldo < 0) {
            throw new Exception('El egreso excede el saldo actual de la caja.');
        }

        $movimiento = DB::transaction(function () use ($caja, $usuario, $tipo, $concepto, $categoriaMovimientoId, $monto, $moneda, $metodoPagoId, $referenciaTipo, $referenciaId, $comprobanteNumero, $descripcion, $saldoActual, $nuevoSaldo) {
            // Crear movimiento
            $movimiento = CajaMovimiento::create([
                'caja_id' => $caja->id,
                'usuario_id' => $usuario->id,
                'tipo' => $tipo,
                'concepto' => $concepto,
                'categoria_movimiento_id' => $categoriaMovimientoId,
                'monto' => $monto,
                'moneda' => $moneda,
                'metodo_pago_id' => $metodoPagoId,
                'referencia_tipo' => $referenciaTipo,
                'referencia_id' => $referenciaId,
                'comprobante_numero' => $comprobanteNumero,
                'saldo_anterior' => $saldoActual,
                'saldo_posterior' => $nuevoSaldo,
                'descripcion' => $descripcion,
            ]);

            // Actualizar saldo actual de la caja
            $caja->saldo_actual = $nuevoSaldo;
            $caja->save();

            return $movimiento;
        });

        return $movimiento;
    }
}
