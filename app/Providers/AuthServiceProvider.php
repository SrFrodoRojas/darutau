<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Deposito;
use App\Models\Producto;
use App\Models\ProductoSerial;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Impuesto;
use App\Models\MetodoPago;
use App\Models\CategoriaMovimiento;
use App\Models\EstadoVenta;
use App\Policies\DepositoPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\ProductoSerialPolicy;
use App\Policies\CategoriaPolicy;
use App\Policies\MarcaPolicy;
use App\Policies\ImpuestoPolicy;
use App\Policies\MetodoPagoPolicy;
use App\Policies\CategoriaMovimientoPolicy;
use App\Policies\EstadoVentaPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Deposito::class => DepositoPolicy::class,
        Producto::class => ProductoPolicy::class,
        ProductoSerial::class => ProductoSerialPolicy::class,
        Categoria::class => CategoriaPolicy::class,
        Marca::class => MarcaPolicy::class,
        Impuesto::class => ImpuestoPolicy::class,
        MetodoPago::class => MetodoPagoPolicy::class,
        CategoriaMovimiento::class => CategoriaMovimientoPolicy::class,
        EstadoVenta::class => EstadoVentaPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Opcional: Gates adicionales si los necesitas
        Gate::define('ajustar-stock', [ProductoPolicy::class, 'ajustarStock']);
        Gate::define('ver-stock', function ($user) {
            return in_array($user->rol->nombre, ['ADMIN', 'GERENTE', 'DEPOSITO', 'VENTAS']);
        });
    }
}
