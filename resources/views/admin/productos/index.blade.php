@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Productos</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.productos.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Producto
            </a>
        </div>
        <div class="card-body">
            <table id="tabla-productos" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Precio Venta</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(function () {
        $('#tabla-productos').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.productos.data") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'codigo', name: 'codigo' },
                { data: 'nombre', name: 'nombre' },
                { data: 'marca.nombre', name: 'marca.nombre', defaultContent: '' },
                { data: 'categoria.nombre', name: 'categoria.nombre', defaultContent: '' },
                { data: 'precio_venta', name: 'precio_venta' },
                { data: 'activo', name: 'activo' },
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
        });
    });
</script>
@endsection
