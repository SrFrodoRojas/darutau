@extends('adminlte::page')

@section('title', 'Detalle Serial')

@section('content_header')
    <h1>Serial: {{ $serial->serial }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>Producto</th><td>{{ $serial->producto->nombre }}</td></tr>
                <tr><th>Serial</th><td>{{ $serial->serial }}</td></tr>
                <tr><th>Estado</th><td><span class="badge badge-{{ $serial->estado == 'disponible' ? 'success' : ($serial->estado == 'vendido' ? 'danger' : 'warning') }}">{{ ucfirst($serial->estado) }}</span></td></tr>
                <tr><th>Fecha Ingreso</th><td>{{ $serial->fecha_ingreso }}</td></tr>
                <tr><th>Fecha Salida</th><td>{{ $serial->fecha_salida ?: '-' }}</td></tr>
                <tr><th>Vencimiento Garantía</th><td>{{ $serial->fecha_vencimiento_garantia ?: '-' }}</td></tr>
                <tr><th>Proveedor</th><td>{{ $serial->proveedor->nombre ?? '-' }}</td></tr>
                <tr><th>Notas</th><td>{{ $serial->notas ?: '-' }}</td></tr>
            </table>
            <h5>Historial de Movimientos</h5>
            <table class="table table-sm">
                <thead><tr><th>Fecha</th><th>Movimiento</th><th>Referencia</th><th>Estado Anterior</th><th>Estado Nuevo</th><th>Notas</th></tr></thead>
                <tbody>
                    @foreach($serial->movimientos as $mov)
                        <tr>
                            <td>{{ $mov->created_at }}</td>
                            <td>{{ $mov->tipo_movimiento }}</td>
                            <td>{{ $mov->referencia_tipo }} #{{ $mov->referencia_id }}</td>
                            <td>{{ $mov->estado_anterior ?: '-' }}</td>
                            <td>{{ $mov->estado_nuevo ?: '-' }}</td>
                            <td>{{ $mov->notas ?: '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('admin.seriales.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@endsection
