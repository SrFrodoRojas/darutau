@extends('adminlte::page')

@section('title', 'Seriales')

@section('content_header')
    <h1>Seriales / Números de Serie</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.seriales.create') }}" class="btn btn-primary btn-sm">Nuevo Serial</a>
        </div>
        <div class="card-body">
            <table id="tabla-seriales" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Serial</th>
                        <th>Estado</th>
                        <th>Proveedor</th>
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
        $('#tabla-seriales').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.seriales.data") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'producto.nombre', name: 'producto.nombre' },
                { data: 'serial', name: 'serial' },
                { data: 'estado', name: 'estado' },
                { data: 'proveedor.nombre', name: 'proveedor.nombre', defaultContent: '' },
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
        });
    });
</script>
@endsection
