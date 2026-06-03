<?php

use App\Http\Controllers\Admin\DepositoController;
use App\Http\Controllers\Admin\HistorialController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProductoImagenController;
use App\Http\Controllers\Admin\ProductoSerialController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth', 'empresa'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== CATÁLOGOS MAESTROS (FASE 2) ====================
    Route::prefix('admin')->name('admin.')->group(function () {
        // Categorías
        Route::resource('categorias', App\Http\Controllers\Admin\CategoriaController::class);
        Route::get('categorias/data', [App\Http\Controllers\Admin\CategoriaController::class, 'data'])->name('categorias.data');

        // Marcas
        Route::resource('marcas', App\Http\Controllers\Admin\MarcaController::class);
        Route::get('marcas/data', [App\Http\Controllers\Admin\MarcaController::class, 'data'])->name('marcas.data');

        // Impuestos
        Route::resource('impuestos', App\Http\Controllers\Admin\ImpuestoController::class);
        Route::get('impuestos/data', [App\Http\Controllers\Admin\ImpuestoController::class, 'data'])->name('impuestos.data');

        // Métodos de Pago
        Route::resource('metodo-pagos', App\Http\Controllers\Admin\MetodoPagoController::class);
        Route::get('metodo-pagos/data', [App\Http\Controllers\Admin\MetodoPagoController::class, 'data'])->name('metodo-pagos.data');

        // Categorías de Movimiento (Caja)
        Route::resource('categoria-movimientos', App\Http\Controllers\Admin\CategoriaMovimientoController::class);
        Route::get('categoria-movimientos/data', [App\Http\Controllers\Admin\CategoriaMovimientoController::class, 'data'])->name('categoria-movimientos.data');

        // Estados de Venta
        Route::resource('estado-ventas', App\Http\Controllers\Admin\EstadoVentaController::class)->except(['destroy']);
        Route::get('estado-ventas/data', [App\Http\Controllers\Admin\EstadoVentaController::class, 'data'])->name('estado-ventas.data');

        // Depósitos
        Route::resource('depositos', DepositoController::class);
        Route::get('depositos/data', [DepositoController::class, 'data'])->name('depositos.data');

        // Productos
        Route::resource('productos', ProductoController::class);
        Route::get('productos/data', [ProductoController::class, 'data'])->name('productos.data');

        // Imágenes de producto (AJAX)
        Route::post('productos/{producto}/imagenes', [ProductoImagenController::class, 'store'])->name('productos.imagenes.store');
        Route::delete('productos/imagenes/{imagen}', [ProductoImagenController::class, 'destroy'])->name('productos.imagenes.destroy');
        Route::put('productos/imagenes/{imagen}/principal', [ProductoImagenController::class, 'setPrincipal'])->name('productos.imagenes.principal');

        // Stock
        Route::get('stock', [StockController::class, 'index'])->name('stock.index');
        Route::get('stock/movimientos', [StockController::class, 'movimientos'])->name('stock.movimientos');
        Route::get('stock/ajuste', [StockController::class, 'ajusteForm'])->name('stock.ajuste.form');
        Route::post('stock/ajuste', [StockController::class, 'ajusteStore'])->name('stock.ajuste.store');

        // Seriales
        Route::resource('seriales', ProductoSerialController::class);
        Route::get('seriales/data', [ProductoSerialController::class, 'data'])->name('seriales.data');

        // Historiales
        Route::get('historial/precios', [HistorialController::class, 'precios'])->name('historial.precios');
        Route::get('historial/costos', [HistorialController::class, 'costos'])->name('historial.costos');

        Route::prefix('admin')->middleware(['auth', 'empresa'])->group(function () {
            // Clientes
            Route::resource('clientes', \App\Http\Controllers\Admin\ClienteController::class)->except(['show']);
            Route::get('clientes/{cliente}', [\App\Http\Controllers\Admin\ClienteController::class, 'show'])->name('admin.clientes.show');
            Route::post('clientes/{id}/restore', [\App\Http\Controllers\Admin\ClienteController::class, 'restore'])->name('admin.clientes.restore')->withTrashed();
            Route::delete('clientes/{id}/force', [\App\Http\Controllers\Admin\ClienteController::class, 'forceDelete'])->name('admin.clientes.forceDelete')->withTrashed();
            Route::get('clientes-data', [\App\Http\Controllers\Admin\ClienteController::class, 'data'])->name('admin.clientes.data');

            // Pagos de clientes
            Route::prefix('clientes/pagos')->name('admin.clientes.pagos.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\ClientePagoController::class, 'index'])->name('index');
                Route::get('data', [\App\Http\Controllers\Admin\ClientePagoController::class, 'data'])->name('data');
                Route::get('create', [\App\Http\Controllers\Admin\ClientePagoController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\Admin\ClientePagoController::class, 'store'])->name('store');
                Route::get('{pago}', [\App\Http\Controllers\Admin\ClientePagoController::class, 'show'])->name('show');
            });

            // Proveedores
            Route::resource('proveedores', \App\Http\Controllers\Admin\ProveedorController::class)->except(['show']);
            Route::get('proveedores/{proveedor}', [\App\Http\Controllers\Admin\ProveedorController::class, 'show'])->name('admin.proveedores.show');
            Route::get('proveedores-data', [\App\Http\Controllers\Admin\ProveedorController::class, 'data'])->name('admin.proveedores.data');

            // Pagos a proveedores
            Route::prefix('proveedores/pagos')->name('admin.proveedores.pagos.')->group(function () {
                Route::get('/', [\App\Http\Controllers\Admin\ProveedorPagoController::class, 'index'])->name('index');
                Route::get('data', [\App\Http\Controllers\Admin\ProveedorPagoController::class, 'data'])->name('data');
                Route::get('create', [\App\Http\Controllers\Admin\ProveedorPagoController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\Admin\ProveedorPagoController::class, 'store'])->name('store');
                Route::get('{pago}', [\App\Http\Controllers\Admin\ProveedorPagoController::class, 'show'])->name('show');
            });
        });
    });
    // =====================================================================

    // Ejemplo de ruta con restricción de rol
    Route::middleware(['rol:ADMIN,GERENTE'])->group(function () {
        // Aquí van rutas solo para admin y gerente (productos, compras, etc. - Fases posteriores)
    });
});
