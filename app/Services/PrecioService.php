<?php

namespace App\Services;

use App\Models\Producto;
use App\Models\PrecioHistorial;
use Illuminate\Support\Facades\Auth;

class PrecioService
{
    public function actualizarPrecioVenta($productoId, $nuevoPrecio, $usuarioId = null)
    {
        $producto = Producto::findOrFail($productoId);
        $precioAnterior = $producto->precio_venta;

        if ($precioAnterior == $nuevoPrecio) {
            return $producto;
        }

        $producto->precio_venta = $nuevoPrecio;
        $producto->save();

        PrecioHistorial::create([
            'producto_id' => $productoId,
            'precio_anterior' => $precioAnterior,
            'precio_nuevo' => $nuevoPrecio,
            'usuario_id' => $usuarioId ?? Auth::id(),
        ]);

        return $producto;
    }
}
