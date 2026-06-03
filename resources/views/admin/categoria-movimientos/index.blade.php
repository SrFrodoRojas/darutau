@extends('adminlte::page')

@section('title', 'Categorías de Movimiento')

@section('content_header')
    <h1>Categorías de Movimiento (Caja)</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.categoria-movimientos.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Nueva Categoría</a>
            <div class="float-right">
                <select id="filtro_activo" class="form-control form-control-sm d-inline-block w-auto">
                    <option value="">Todos (Activo)</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>
                <select id="filtro_tipo" class="form-control form-control-sm d-inline-block w-auto ml-2">
                    <option value="">Todos los tipos</option>
                    <option value="ingreso">Ingreso</option>
                    <option value="egreso">Egreso</option>
                </select>
                <input type="text" id="filtro_search" class="form-control form-control-sm d-inline-block w-auto ml-2" placeholder="Buscar...">
            </div>
        </div>
        <div class="card-body">
            <table id="tabla" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Activo</th>
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
            url: "{{ route('admin.categoria-movimientos.data') }}",
            data: function(d) {
                d.activo = $('#filtro_activo').val();
                d.tipo = $('#filtro_tipo').val();
                d.search = $('#filtro_search').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nombre', name: 'nombre' },
            { data: 'tipo', name: 'tipo' },
            { data: 'activo', name: 'activo' },
            { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
    });

    $('#filtro_activo, #filtro_tipo, #filtro_search').on('change keyup', function() {
        table.ajax.reload();
    });

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let url = $(this).data('url');
        Swal.fire({
            title: '¿Desactivar?',
            text: "La categoría se marcará como inactiva.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Sí, desactivar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        table.ajax.reload();
                        Swal.fire('Desactivada', 'Categoría desactivada correctamente.', 'success');
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo desactivar.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@stop
