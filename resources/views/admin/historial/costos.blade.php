@extends('adminlte::page')

@section('title', 'Historial de Costos')

@section('content_header')
    <h1>Historial de Cambios de Costo Promedio</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="tabla-costos" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Costo Anterior</th>
                        <th>Costo Nuevo</th>
                        <th>Motivo</th>
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
        $('#tabla-costos').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.historial.costos") }}?ajax=1',
            columns: [
                { data: 'created_at', name: 'created_at' },
                { data: 'producto_nombre', name: 'producto_nombre' },
                { data: 'costo_anterior', name: 'costo_anterior' },
                { data: 'costo_nuevo', name: 'costo_nuevo' },
                { data: 'motivo', name: 'motivo', defaultContent: '' },
                { data: 'usuario_nombre', name: 'usuario_nombre' }
            ],
            order: [[0, 'desc']],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
        });
    });
</script>
@endsection
