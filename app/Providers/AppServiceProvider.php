<?php

namespace App\Providers;

use App\Services\CajaService;
use App\Services\CreditoClienteService;
use App\Services\CreditoProveedorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CajaService::class, function ($app) {
            return new CajaService();
        });
        $this->app->singleton(CreditoClienteService::class, function ($app) {
            return new CreditoClienteService($app->make(CajaService::class));
        });
        $this->app->singleton(CreditoProveedorService::class, function ($app) {
            return new CreditoProveedorService($app->make(CajaService::class));
        });
    }

    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $user = Auth::user();
            if (!$user || !$user->rol)
                return;

            $rolCodigo = $user->rol->codigo;  // ← Cambiado de 'nombre' a 'codigo'

            $menu = [
                ['text' => 'Dashboard', 'url' => '/dashboard', 'icon' => 'tachometer-alt'],
            ];

            // ================= INVENTARIO =================
            if (in_array($rolCodigo, ['ADMIN', 'GERENTE', 'DEPOSITO', 'VENTAS'])) {
                $menu[] = ['header' => 'INVENTARIO'];
                $menu[] = ['text' => 'Categorías', 'url' => '/admin/categorias', 'icon' => 'tags'];
                $menu[] = ['text' => 'Marcas', 'url' => '/admin/marcas', 'icon' => 'tag'];
                $menu[] = ['text' => 'Impuestos', 'url' => '/admin/impuestos', 'icon' => 'calculator'];
                $menu[] = ['text' => 'Productos', 'url' => '/admin/productos', 'icon' => 'box'];
                $menu[] = ['text' => 'Depósitos', 'url' => '/admin/depositos', 'icon' => 'warehouse'];
                $menu[] = ['text' => 'Stock', 'url' => '/admin/stock', 'icon' => 'cubes'];

                if (in_array($rolCodigo, ['ADMIN', 'GERENTE'])) {
                    $menu[] = ['text' => 'Seriales', 'url' => '/admin/seriales', 'icon' => 'barcode'];
                    $menu[] = ['text' => 'Historial Precios', 'url' => '/admin/historial/precios', 'icon' => 'chart-line'];
                    $menu[] = ['text' => 'Historial Costos', 'url' => '/admin/historial/costos', 'icon' => 'coins'];
                }
            }

            // ================= COMPRAS =================
            if (in_array($rolCodigo, ['ADMIN', 'GERENTE'])) {
                $menu[] = ['header' => 'COMPRAS'];
                $menu[] = ['text' => 'Compras', 'url' => '/compras', 'icon' => 'shopping-cart'];
                // El ítem simple de Proveedores se elimina (ahora está con submenú más abajo)
            }

            // ================= VENTAS =================
            if (in_array($rolCodigo, ['ADMIN', 'GERENTE', 'VENTAS'])) {
                $menu[] = ['header' => 'VENTAS'];
                $menu[] = ['text' => 'Ventas', 'url' => '/ventas', 'icon' => 'credit-card'];
                // El ítem simple de Clientes se elimina (ahora está con submenú)
            }

            // ================= CAJA =================
            if (in_array($rolCodigo, ['ADMIN', 'GERENTE', 'CAJA'])) {
                $menu[] = ['header' => 'CAJA'];
                $menu[] = ['text' => 'Apertura', 'url' => '/caja/apertura', 'icon' => 'cash-register'];
                $menu[] = ['text' => 'Movimientos', 'url' => '/caja/movimientos', 'icon' => 'exchange-alt'];
                $menu[] = ['text' => 'Arqueos', 'url' => '/caja/arqueos', 'icon' => 'clipboard-list'];
            }

            // ================= MOVIMIENTOS DE STOCK =================
            if (in_array($rolCodigo, ['ADMIN', 'GERENTE', 'DEPOSITO'])) {
                $menu[] = ['header' => 'MOVIMIENTOS'];
                $menu[] = ['text' => 'Movimientos de Stock', 'url' => '/admin/stock/movimientos', 'icon' => 'history'];
                $menu[] = ['text' => 'Ajuste de Stock', 'url' => '/admin/stock/ajuste', 'icon' => 'sliders-h'];
            }

            // ================= CLIENTES =================
            if (Gate::forUser($user)->allows('viewAny', \App\Models\Cliente::class)) {
                $menu[] = [
                    'text' => 'Clientes',
                    'icon' => 'fas fa-users',
                    'submenu' => [
                        ['text' => 'Listado', 'url' => route('admin.clientes.index'), 'icon' => 'fas fa-list'],
                        ['text' => 'Nuevo Cliente', 'url' => route('admin.clientes.create'), 'icon' => 'fas fa-plus', 'can' => 'create,App\Models\Cliente'],
                        ['text' => 'Pagos', 'url' => route('admin.clientes.pagos.index'), 'icon' => 'fas fa-hand-holding-usd', 'can' => 'makePayment,App\Models\ClientePago'],
                    ]
                ];
            }

            // ================= PROVEEDORES =================
            if (Gate::forUser($user)->allows('viewAny', \App\Models\Proveedor::class)) {
                $menu[] = [
                    'text' => 'Proveedores',
                    'icon' => 'fas fa-truck',
                    'submenu' => [
                        ['text' => 'Listado', 'url' => route('admin.proveedores.index'), 'icon' => 'fas fa-list'],
                        ['text' => 'Nuevo Proveedor', 'url' => route('admin.proveedores.create'), 'icon' => 'fas fa-plus', 'can' => 'create,App\Models\Proveedor'],
                        ['text' => 'Pagos', 'url' => route('admin.proveedores.pagos.index'), 'icon' => 'fas fa-hand-holding-usd', 'can' => 'makePayment,App\Models\ProveedorPago'],
                    ]
                ];
            }

            // ================= CONFIGURACIÓN =================
            if ($rolCodigo === 'ADMIN') {
                $menu[] = ['header' => 'CONFIGURACIÓN'];
                $menu[] = ['text' => 'Usuarios', 'url' => '/usuarios', 'icon' => 'user-cog'];
                $menu[] = ['text' => 'Roles', 'url' => '/roles', 'icon' => 'user-tag'];
                $menu[] = ['text' => 'Empresas', 'url' => '/empresas', 'icon' => 'building'];
                $menu[] = ['text' => 'Métodos de Pago', 'url' => '/admin/metodo-pagos', 'icon' => 'money-bill'];
                $menu[] = ['text' => 'Categorías de Movimiento', 'url' => '/admin/categoria-movimientos', 'icon' => 'chart-line'];
                $menu[] = ['text' => 'Estados de Venta', 'url' => '/admin/estado-ventas', 'icon' => 'tag'];
            } elseif ($rolCodigo === 'GERENTE') {
                $menu[] = ['header' => 'CONFIGURACIÓN'];
                $menu[] = ['text' => 'Métodos de Pago', 'url' => '/admin/metodo-pagos', 'icon' => 'money-bill'];
                $menu[] = ['text' => 'Categorías de Movimiento', 'url' => '/admin/categoria-movimientos', 'icon' => 'chart-line'];
                $menu[] = ['text' => 'Estados de Venta', 'url' => '/admin/estado-ventas', 'icon' => 'tag'];
            }

            // Agregar todo el menú de una vez
            $event->menu->add($menu);
        });
    }
}
