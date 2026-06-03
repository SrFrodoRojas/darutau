@extends('adminlte::page')

@section('title', 'Movimientos de Stock')

@section('content_header')
    <h1>Historial de Movimientos de Stock</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="tabla-movimientos" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Depósito</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Stock Previo</th>
                        <th>Stock Posterior</th>
                        <th>Usuario</th>
                        <th>Notas</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(function () {
        $('#tabla-movimientos').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.stock.movimientos") }}?ajax=1',
            columns: [
                { data: 'created_at', name: 'created_at' },
                { data: 'producto_nombre', name: 'producto_nombre' },
                { data: 'deposito_nombre', name: 'deposito_nombre' },
                { data: 'tipo', name: 'tipo' },
                { data: 'cantidad', name: 'cantidad' },
                { data: 'stock_prev', name: 'stock_prev' },
                { data: 'stock_post', name: 'stock_post' },
                { data: 'usuario.name', name: 'usuario.name', defaultContent: '' },
                { data: 'notas', name: 'notas' }
            ],
            order: [[0, 'desc']],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json' }
        });
    });
</script>
@endsection
