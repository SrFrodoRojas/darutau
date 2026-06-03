@extends('adminlte::page')

@section('title', 'Detalle Producto')

@section('content_header')
    <h1>{{ $producto->nombre }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs" id="productoTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#info">Información</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#imagenes">Imágenes</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#stock">Stock por Depósito</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#seriales">Seriales</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#historial">Historial Precios/Costos</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="info">
                    <table class="table table-bordered">
                        <tr><th>Código</th><td>{{ $producto->codigo ?: 'N/A' }}</td></tr>
                        <tr><th>Código Barras</th><td>{{ $producto->codigo_barras ?: 'N/A' }}</td></tr>
                        <tr><th>Nombre</th><td>{{ $producto->nombre }}</td></tr>
                        <tr><th>Descripción</th><td>{{ $producto->descripcion ?: 'Sin descripción' }}</td></tr>
                        <tr><th>Categoría</th><td>{{ $producto->categoria->nombre ?? 'N/A' }}</td></tr>
                        <tr><th>Marca</th><td>{{ $producto->marca->nombre ?? 'N/A' }}</td></tr>
                        <tr><th>Precio Compra</th><td>{{ number_format($producto->precio_compra, 0, ',', '.') }} Gs.</td></tr>
                        <tr><th>Precio Venta</th><td>{{ number_format($producto->precio_venta, 0, ',', '.') }} Gs.</td></tr>
                        <tr><th>Costo Promedio FOB</th><td>{{ number_format($producto->costo_promedio_fob ?? 0, 0, ',', '.') }} Gs.</td></tr>
                        <tr><th>Costo Promedio CIF</th><td>{{ number_format($producto->costo_promedio_cif ?? 0, 0, ',', '.') }} Gs.</td></tr>
                        <tr><th>Unidad Medida</th><td>{{ $producto->unidad_medida }}</td></tr>
                        <tr><th>Peso (g)</th><td>{{ $producto->peso_gramos ?: 'N/A' }}</td></tr>
                        <tr><th>Activo</th><td>{!! $producto->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>' !!}</td></tr>
                        <tr><th>Destacado Web</th><td>{!! $producto->destacado ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-secondary">No</span>' !!}</td></tr>
                        <tr><th>Usa Serial</th><td>{!! $producto->usa_serial ? '<span class="badge badge-info">Sí</span>' : '<span class="badge badge-secondary">No</span>' !!}</td></tr>
                        <tr><th>Mostrar Web</th><td>{!! $producto->mostrar_web ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-secondary">No</span>' !!}</td></tr>
                    </table>
                </div>
                <div class="tab-pane" id="imagenes">
                    <div class="row" id="galeria">
                        @foreach($producto->imagenes as $img)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <img src="{{ asset('storage/' . $img->ruta) }}" class="card-img-top" alt="{{ $img->alt_text }}" style="height: 150px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        @if($img->principal)
                                            <span class="badge badge-primary">Principal</span>
                                        @else
                                            <button class="btn btn-sm btn-outline-primary set-principal" data-id="{{ $img->id }}">Marcar Principal</button>
                                        @endif
                                        <button class="btn btn-sm btn-danger delete-imagen" data-id="{{ $img->id }}">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <form id="form-imagen" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Agregar nueva imagen</label>
                            <input type="file" name="imagen" class="form-control-file" accept="image/*" required>
                            <input type="text" name="alt_text" class="form-control mt-2" placeholder="Texto alternativo">
                        </div>
                        <button type="submit" class="btn btn-primary">Subir Imagen</button>
                    </form>
                </div>
                <div class="tab-pane" id="stock">
                    <table class="table table-bordered">
                        <thead>
                            <tr><th>Depósito</th><th>Stock Físico</th><th>Reservado</th><th>Disponible</th><th>Mínimo</th><th>Máximo</th></tr>
                        </thead>
                        <tbody>
                            @foreach($stockPorDeposito as $sd)
                                <tr>
                                    <td>{{ $sd->deposito->nombre }}</td>
                                    <td>{{ number_format($sd->stock) }}</td>
                                    <td>{{ number_format($sd->stock_reservado) }}</td>
                                    <td>{{ number_format($sd->stock - $sd->stock_reservado) }}</td>
                                    <td>{{ $sd->stock_minimo ?? '-' }}</td>
                                    <td>{{ $sd->stock_maximo ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="seriales">
                    <table class="table table-bordered" id="tabla-seriales">
                        <thead><tr><th>Serial</th><th>Estado</th><th>Fecha Ingreso</th><th>Garantía</th><th>Proveedor</th></tr></thead>
                        <tbody>
                            @foreach($producto->seriales as $serial)
                                <tr>
                                    <td>{{ $serial->serial }}</td>
                                    <td><span class="badge badge-{{ $serial->estado == 'disponible' ? 'success' : ($serial->estado == 'vendido' ? 'danger' : 'warning') }}">{{ ucfirst($serial->estado) }}</span></td>
                                    <td>{{ $serial->fecha_ingreso }}</td>
                                    <td>{{ $serial->fecha_vencimiento_garantia ?: '-' }}</td>
                                    <td>{{ $serial->proveedor->nombre ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="historial">
                    <h5>Historial de Precios de Venta</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Fecha</th><th>Precio Anterior</th><th>Precio Nuevo</th><th>Usuario</th></tr></thead>
                        <tbody>
                            @foreach($producto->precioHistorial->sortByDesc('created_at') as $ph)
                                <tr><td>{{ $ph->created_at }}</td><td>{{ number_format($ph->precio_anterior, 0) }}</td><td>{{ number_format($ph->precio_nuevo, 0) }}</td><td>{{ $ph->usuario->name ?? 'Sistema' }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h5>Historial de Costos</h5>
                    <table class="table table-sm">
                        <thead><tr><th>Fecha</th><th>Costo Anterior</th><th>Costo Nuevo</th><th>Motivo</th></tr></thead>
                        <tbody>
                            @foreach($producto->costoHistorial->sortByDesc('created_at') as $ch)
                                <tr><td>{{ $ch->created_at }}</td><td>{{ number_format($ch->costo_anterior, 0) }}</td><td>{{ number_format($ch->costo_nuevo, 0) }}</td><td>{{ $ch->motivo ?: '-' }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@endsection

@section('js')
<script>
    // Subir imagen
    $('#form-imagen').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('producto_id', {{ $producto->id }});
        $.ajax({
            url: '{{ route("admin.productos.imagenes.store", $producto) }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) location.reload();
                else alert('Error al subir imagen');
            },
            error: function() { alert('Error'); }
        });
    });
    // Marcar principal
    $('.set-principal').on('click', function() {
        let id = $(this).data('id');
        $.ajax({
            url: '{{ url("admin/productos/imagenes") }}/' + id + '/principal',
            method: 'PUT',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) { location.reload(); }
        });
    });
    // Eliminar imagen
    $('.delete-imagen').on('click', function() {
        if (!confirm('¿Eliminar esta imagen?')) return;
        let id = $(this).data('id');
        $.ajax({
            url: '{{ url("admin/productos/imagenes") }}/' + id,
            method: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) { location.reload(); }
        });
    });
</script>
@endsection
