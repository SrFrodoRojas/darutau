@extends('adminlte::page')
@section('title', 'Impuestos')
@section('content_header')
    <h1>Impuestos</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.impuestos.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Impuesto</a>
            <div class="float-right">
                <select id="filtro_activo" class="form-control form-control-sm d-inline-block w-auto">
                    <option value="">Todos</option><option value="1">Activos</option><option value="0">Inactivos</option>
                </select>
                <input type="text" id="filtro_search" class="form-control form-control-sm d-inline-block w-auto ml-2" placeholder="Buscar...">
            </div>
        </div>
        <div class="card-body">
            <table id="tabla" class="table table-bordered">
                <thead><tr><th>ID</th><th>Nombre</th><th>Porcentaje</th><th>Activo</th><th width="80">Acciones</th></tr></thead>
            </table>
        </div>
    </div>
@stop
@section('js')
<script>
$(function() {
    var table = $('#tabla').DataTable({
        processing: true, serverSide: true,
        ajax: { url: "{{ route('admin.impuestos.data') }}", data: function(d) { d.activo = $('#filtro_activo').val(); d.search = $('#filtro_search').val(); } },
        columns: [
            { data: 'id' }, { data: 'nombre' }, { data: 'porcentaje' }, { data: 'activo' }, { data: 'acciones', orderable: false, searchable: false }
        ],
        language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
    });
    $('#filtro_activo, #filtro_search').on('change keyup', function() { table.ajax.reload(); });
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault(); let url = $(this).data('url');
        Swal.fire({ title: '¿Desactivar?', text: "Se marcará como inactivo.", icon: 'warning', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Sí, desactivar' })
        .then((result) => { if (result.isConfirmed) { $.ajax({ url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' }, success: function() { table.ajax.reload(); Swal.fire('Desactivado', '', 'success'); } }); } });
    });
});
</script>
@stop
