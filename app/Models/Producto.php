<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;
use App\Traits\BelongsToEmpresa;

class Producto extends Model
{
    use SoftDeletes, Auditable, BelongsToEmpresa;

    protected $table = 'producto';
    protected $fillable = [
        'codigo', 'codigo_barras', 'nombre', 'descripcion', 'referencia',
        'precio_compra', 'moneda_precio_compra', 'costo_promedio_fob', 'costo_promedio_cif',
        'ultimo_costo_fob', 'ultimo_costo_cif', 'precio_venta', 'moneda_precio_venta',
        'unidad_medida', 'peso_gramos', 'dimensiones', 'categoria_id', 'marca_id',
        'activo', 'destacado', 'usa_serial', 'mostrar_web', 'precio_incluye_iva', 'impuesto_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function impuesto()
    {
        return $this->belongsTo(Impuesto::class);
    }

    public function imagenes()
    {
        return $this->hasMany(ProductoImagen::class);
    }

    public function depositoProductos()
    {
        return $this->hasMany(DepositoProducto::class);
    }

    public function stockMovimientos()
    {
        return $this->hasMany(StockMovimiento::class);
    }

    public function seriales()
    {
        return $this->hasMany(ProductoSerial::class);
    }

    public function precioHistorial()
    {
        return $this->hasMany(PrecioHistorial::class);
    }

    public function costoHistorial()
    {
        return $this->hasMany(CostoHistorial::class);
    }
}
