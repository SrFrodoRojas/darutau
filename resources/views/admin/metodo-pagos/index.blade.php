@extends('adminlte::page')

@section('title', 'Métodos de Pago')

@section('content_header')
    <h1>Métodos de Pago</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.metodo-pagos.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Método de Pago</a>
            <div class="float-right">
                <select id="filtro_activo" class="form-control form-control-sm d-inline-block w-auto">
                    <option value="">Todos (Activo)</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>
                <select id="filtro_referencia" class="form-control form-control-sm d-inline-block w-auto ml-2">
                    <option value="">¿Requiere referencia?</option>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
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
                        <th>Código</th>
                        <th>Requiere referencia</th>
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
            url: "{{ route('admin.metodo-pagos.data') }}",
            data: function(d) {
                d.activo = $('#filtro_activo').val();
                d.requiere_referencia = $('#filtro_referencia').val();
                d.search = $('#filtro_search').val();
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nombre', name: 'nombre' },
            { data: 'codigo', name: 'codigo' },
            { data: 'requiere_referencia', name: 'requiere_referencia' },
            { data: 'activo', name: 'activo' },
            { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
    });

    $('#filtro_activo, #filtro_referencia, #filtro_search').on('change keyup', function() {
        table.ajax.reload();
    });

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let url = $(this).data('url');
        Swal.fire({
            title: '¿Desactivar?',
            text: "El método de pago se marcará como inactivo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, desactivar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        table.ajax.reload();
                        Swal.fire('Desactivado', 'El método de pago ha sido desactivado.', 'success');
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
