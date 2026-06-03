<?php

namespace App\Services;

use App\Models\Proveedor;
use App\Models\ProveedorCreditoMovimiento;
use App\Models\ProveedorPago;
use App\Models\Caja;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\DB;

class CreditoProveedorService
{
    protected CajaService $cajaService;

    public function __construct(CajaService $cajaService)
    {
        $this->cajaService = $cajaService;
    }

    /**
     * Actualizar saldo de crédito del proveedor.
     *
     * @param Proveedor $proveedor
     * @param int $monto
     * @param string $tipoMovimiento 'debito' (aumenta deuda) o 'credito' (reduce deuda)
     * @param string|null $descripcion
     * @param int|null $compraId
     * @param int|null $pagoId
     * @param string|null $fechaVencimiento
     * @return ProveedorCreditoMovimiento
     * @throws Exception
     */
    public function actualizarSaldo(
        Proveedor $proveedor,
        int $monto,
        string $tipoMovimiento,
        ?string $descripcion = null,
        ?int $compraId = null,
        ?int $pagoId = null,
        ?string $fechaVencimiento = null
    ): ProveedorCreditoMovimiento {
        if ($monto <= 0) {
            throw new Exception('El monto debe ser mayor a cero.');
        }

        $credito = $proveedor->credito;
        if (!$credito) {
            throw new Exception('El proveedor no tiene configuración de crédito.');
        }

        $saldoAnterior = (int) $credito->saldo_actual;
        $nuevoSaldo = $saldoAnterior;

        if ($tipoMovimiento === 'credito') {
            // Aumenta el saldo (compra a crédito, el proveedor nos debe)
            $nuevoSaldo += $monto;
        } elseif ($tipoMovimiento === 'debito') {
            // Reduce el saldo (pago al proveedor)
            $nuevoSaldo -= $monto;
            if ($nuevoSaldo < 0) {
                throw new Exception('El pago excede el saldo actual de crédito.');
            }
        } else {
            throw new Exception('Tipo de movimiento inválido. Use "debito" o "credito".');
        }

        DB::transaction(function () use ($proveedor, $credito, $saldoAnterior, $nuevoSaldo, $monto, $tipoMovimiento, $descripcion, $compraId, $pagoId, $fechaVencimiento) {
            $credito->saldo_actual = $nuevoSaldo;
            $credito->save();

            ProveedorCreditoMovimiento::create([
                'proveedor_id' => $proveedor->id,
                'compra_id' => $compraId,
                'pago_id' => $pagoId,
                'tipo' => $tipoMovimiento,
                'monto' => $monto,
                'saldo_anterior' => $saldoAnterior,
                'saldo_posterior' => $nuevoSaldo,
                'fecha_vencimiento' => $fechaVencimiento,
                'descripcion' => $descripcion,
                'created_at' => now(),
            ]);
        });

        return $proveedor->movimientosCredito()->latest('created_at')->first();
    }

    /**
     * Registrar pago a proveedor (afecta crédito y caja como egreso).
     *
     * @param ProveedorPago $pago
     * @param Caja $caja
     * @param Usuario $usuario
     * @return ProveedorCreditoMovimiento
     * @throws Exception
     */
    public function registrarPago(ProveedorPago $pago, Caja $caja, Usuario $usuario): ProveedorCreditoMovimiento
    {
        // Movimiento en caja (egreso)
        $this->cajaService->registrarMovimiento(
            caja: $caja,
            usuario: $usuario,
            tipo: 'egreso',
            concepto: "Pago a proveedor: {$pago->proveedor->nombre}",
            categoriaMovimientoId: 12, // pago_proveedor
            monto: $pago->monto,
            moneda: 'PYG',
            metodoPagoId: $pago->metodo_pago_id,
            referenciaTipo: 'proveedor_pago',
            referenciaId: $pago->id,
            comprobanteNumero: $pago->referencia,
            descripcion: "Pago registrado manualmente"
        );

        // Actualizar crédito (disminuir deuda)
        return $this->actualizarSaldo(
            proveedor: $pago->proveedor,
            monto: $pago->monto,
            tipoMovimiento: 'debito',
            descripcion: "Pago realizado. Ref: {$pago->referencia}",
            pagoId: $pago->id
        );
    }

    /**
     * Verificar crédito disponible para una nueva compra a crédito.
     *
     * @param Proveedor $proveedor
     * @param int $monto
     * @throws Exception
     */
    public function verificarCredito(Proveedor $proveedor, int $monto): void
    {
        $disponible = $proveedor->saldo_disponible;
        // Para proveedores, el "saldo disponible" es límite - saldo_actual (deuda)
        if ($monto > $disponible) {
            throw new Exception("El proveedor no tiene suficiente crédito disponible (Disponible: {$disponible}).");
        }
    }

    public function obtenerSaldoDisponible(Proveedor $proveedor): int
    {
        return $proveedor->saldo_disponible;
    }
}
