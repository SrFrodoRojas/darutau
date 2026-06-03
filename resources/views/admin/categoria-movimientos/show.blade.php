@extends('adminlte::page')

@section('title', 'Ver Categoría de Movimiento')

@section('content_header')
    <h1>Ver Categoría de Movimiento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label><strong>ID:</strong></label>
                <p>{{ $categoriaMovimiento->id }}</p>
            </div>
            <div class="form-group">
                <label><strong>Nombre:</strong></label>
                <p>{{ $categoriaMovimiento->nombre }}</p>
            </div>
            <div class="form-group">
                <label><strong>Tipo:</strong></label>
                <p>{!! $categoriaMovimiento->tipo == 'ingreso' ? '<span class="badge badge-success">Ingreso</span>' : '<span class="badge badge-warning">Egreso</span>' !!}</p>
            </div>
            <div class="form-group">
                <label><strong>Activo:</strong></label>
                <p>{!! $categoriaMovimiento->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>' !!}</p>
            </div>
            <a href="{{ route('admin.categoria-movimientos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop
