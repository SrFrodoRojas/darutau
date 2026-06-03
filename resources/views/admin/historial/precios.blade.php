
@extends('adminlte::page')

@section('title', 'Historial de Precios')

@section('content_header')
    <h1>Historial de Cambios de Precio de Venta</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="tabla-precios" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Precio Anterior</th>
                        <th>Precio Nuevo</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(function () {
        $('#tabla-precios').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.historial.precios") }}?ajax=1',
            columns: [
                { data: 'created_at', name: 'created_at' },
                { data: 'producto_nombre', name: 'producto_nombre' },
                { data: 'precio_anterior', name: 'precio_anterior' },
                { data: 'precio_nuevo', name: 'precio_nuevo' },
                { data: 'usuario_nombre', name: 'usuario_nombre' }
            ],
            order: [[0, 'desc']],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
        });
    });
</script>
@endsection
