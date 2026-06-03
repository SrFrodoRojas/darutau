<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\ClienteCreditoMovimiento;
use App\Models\ClientePago;
use App\Models\Caja;
use App\Models\Usuario;
use Exception;
use Illuminate\Support\Facades\DB;

class CreditoClienteService
{
    protected CajaService $cajaService;

    public function __construct(CajaService $cajaService)
    {
        $this->cajaService = $cajaService;
    }

    /**
     * Actualizar saldo de crédito del cliente y registrar movimiento.
     *
     * @param Cliente $cliente
     * @param int $monto
     * @param string $tipoMovimiento 'debito' (aumenta deuda) o 'credito' (reduce deuda)
     * @param string|null $descripcion
     * @param int|null $ventaId
     * @param int|null $pagoId
     * @param string|null $fechaVencimiento
     * @return ClienteCreditoMovimiento
     * @throws Exception
     */
    public function actualizarSaldo(
        Cliente $cliente,
        int $monto,
        string $tipoMovimiento,
        ?string $descripcion = null,
        ?int $ventaId = null,
        ?int $pagoId = null,
        ?string $fechaVencimiento = null
    ): ClienteCreditoMovimiento {
        if ($monto <= 0) {
            throw new Exception('El monto debe ser mayor a cero.');
        }

        $credito = $cliente->credito;
        if (!$credito) {
            throw new Exception('El cliente no tiene configuración de crédito.');
        }

        $saldoAnterior = (int) $credito->saldo_actual;
        $nuevoSaldo = $saldoAnterior;

        if ($tipoMovimiento === 'debito') {
            // Aumenta la deuda (compra a crédito)
            $nuevoSaldo += $monto;
        } elseif ($tipoMovimiento === 'credito') {
            // Reduce la deuda (pago)
            $nuevoSaldo -= $monto;
            if ($nuevoSaldo < 0) {
                throw new Exception('El pago excede el saldo actual de crédito.');
            }
        } else {
            throw new Exception('Tipo de movimiento inválido. Use "debito" o "credito".');
        }

        DB::transaction(function () use ($cliente, $credito, $saldoAnterior, $nuevoSaldo, $monto, $tipoMovimiento, $descripcion, $ventaId, $pagoId, $fechaVencimiento) {
            // Actualizar saldo en cliente_credito
            $credito->saldo_actual = $nuevoSaldo;
            $credito->save();

            // Registrar movimiento
            ClienteCreditoMovimiento::create([
                'cliente_id' => $cliente->id,
                'venta_id' => $ventaId,
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

        return $cliente->movimientosCredito()->latest('created_at')->first();
    }

    /**
     * Registrar un pago de cliente (afecta crédito y caja).
     *
     * @param ClientePago $pago
     * @param Caja $caja
     * @param Usuario $usuario
     * @return ClienteCreditoMovimiento
     * @throws Exception
     */
    public function registrarPago(ClientePago $pago, Caja $caja, Usuario $usuario): ClienteCreditoMovimiento
    {
        // 1. Registrar movimiento en caja (ingreso)
        $movimientoCaja = $this->cajaService->registrarMovimiento(
            caja: $caja,
            usuario: $usuario,
            tipo: 'ingreso',
            concepto: "Pago de cliente: {$pago->cliente->nombre}",
            categoriaMovimientoId: 13, // cobro_cliente (según insert inicial)
            monto: $pago->monto,
            moneda: 'PYG',
            metodoPagoId: $pago->metodo_pago_id,
            referenciaTipo: 'cliente_pago',
            referenciaId: $pago->id,
            comprobanteNumero: $pago->referencia,
            descripcion: "Pago registrado manualmente"
        );

        // Opcional: actualizar el pago con el id del movimiento de caja? No necesario según estructura.

        // 2. Actualizar crédito del cliente (disminuir deuda)
        $movimientoCredito = $this->actualizarSaldo(
            cliente: $pago->cliente,
            monto: $pago->monto,
            tipoMovimiento: 'credito',
            descripcion: "Pago recibido. Ref: {$pago->referencia}",
            pagoId: $pago->id
        );

        return $movimientoCredito;
    }

    /**
     * Verificar si el cliente tiene crédito suficiente para un nuevo débito.
     *
     * @param Cliente $cliente
     * @param int $monto
     * @throws Exception
     */
    public function verificarCredito(Cliente $cliente, int $monto): void
    {
        $disponible = $cliente->saldo_disponible;
        if ($monto > $disponible) {
            throw new Exception("El cliente no tiene suficiente crédito disponible (Disponible: {$disponible}).");
        }
    }

    /**
     * Obtener el saldo disponible del cliente.
     */
    public function obtenerSaldoDisponible(Cliente $cliente): int
    {
        return $cliente->saldo_disponible;
    }
}
