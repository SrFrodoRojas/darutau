@extends('adminlte::page')

@section('title', 'Estados de Venta')

@section('content_header')
    <h1>Estados de Venta</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.estado-ventas.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Estado</a>
            <div class="float-right">
                <input type="text" id="filtro_search" class="form-control form-control-sm d-inline-block w-auto" placeholder="Buscar...">
            </div>
        </div>
        <div class="card-body">
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Orden</th>
                        <th width="80">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

@section('js')
<script>
$(function() {
    var table = $('#tabla').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.estado-ventas.data') }}",
            data: function(d) {
                d.search = $('#filtro_search').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nombre', name: 'nombre' },
            { data: 'orden', name: 'orden' },
            { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
    });

    $('#filtro_search').on('keyup', function() {
        table.ajax.reload();
    });

    // No hay botón eliminar en este módulo
});
</script>
@stop
