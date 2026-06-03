@extends('adminlte::page')

@section('title', 'Depósitos')

@section('content_header')
    <h1>Depósitos</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.depositos.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nuevo Depósito
            </a>
        </div>
        <div class="card-body">
            <table id="tabla-depositos" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Responsable</th>
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
        $('#tabla-depositos').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.depositos.data") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'nombre', name: 'nombre' },
                { data: 'ubicacion', name: 'ubicacion' },
                { data: 'responsable.name', name: 'responsable.name', defaultContent: '' },
                { data: 'activo', name: 'activo' },
                { data: 'acciones', name: 'acciones', orderable: false, searchable: false }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
        });
    });
</script>
@endsection
