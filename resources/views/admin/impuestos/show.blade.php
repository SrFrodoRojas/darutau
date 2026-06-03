@extends('adminlte::page')
@section('title', 'Ver Impuesto')
@section('content_header')
    <h1>Ver Impuesto</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $impuesto->id }}</p>
            <p><strong>Nombre:</strong> {{ $impuesto->nombre }}</p>
            <p><strong>Porcentaje:</strong> {{ number_format($impuesto->porcentaje, 2) }}%</p>
            <p><strong>Activo:</strong> {!! $impuesto->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>' !!}</p>
            <a href="{{ route('admin.impuestos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop
