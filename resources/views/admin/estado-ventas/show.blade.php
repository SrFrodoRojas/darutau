@extends('adminlte::page')

@section('title', 'Ver Estado de Venta')

@section('content_header')
    <h1>Ver Estado de Venta</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label><strong>ID:</strong></label>
                <p>{{ $estadoVenta->id }}</p>
            </div>
            <div class="form-group">
                <label><strong>Nombre:</strong></label>
                <p>{{ $estadoVenta->nombre }}</p>
            </div>
            <div class="form-group">
                <label><strong>Orden:</strong></label>
                <p>{{ $estadoVenta->orden ?? '-' }}</p>
            </div>
            <a href="{{ route('admin.estado-ventas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop
