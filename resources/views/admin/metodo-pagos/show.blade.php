@extends('adminlte::page')

@section('title', 'Ver Método de Pago')

@section('content_header')
    <h1>Ver Método de Pago</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label><strong>ID:</strong></label>
                <p>{{ $metodoPago->id }}</p>
            </div>
            <div class="form-group">
                <label><strong>Nombre:</strong></label>
                <p>{{ $metodoPago->nombre }}</p>
            </div>
            <div class="form-group">
                <label><strong>Código:</strong></label>
                <p>{{ $metodoPago->codigo }}</p>
            </div>
            <div class="form-group">
                <label><strong>Requiere referencia:</strong></label>
                <p>{!! $metodoPago->requiere_referencia ? '<span class="badge badge-info">Sí</span>' : '<span class="badge badge-secondary">No</span>' !!}</p>
            </div>
            <div class="form-group">
                <label><strong>Activo:</strong></label>
                <p>{!! $metodoPago->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>' !!}</p>
            </div>
            <a href="{{ route('admin.metodo-pagos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop
