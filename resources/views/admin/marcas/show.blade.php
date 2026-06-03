@extends('adminlte::page')

@section('title', 'Ver Marca')

@section('content_header')
    <h1>Ver Marca</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group"><label><strong>ID:</strong></label><p>{{ $marca->id }}</p></div>
            <div class="form-group"><label><strong>Nombre:</strong></label><p>{{ $marca->nombre }}</p></div>
            <div class="form-group"><label><strong>Descripción:</strong></label><p>{{ $marca->descripcion ?: '-' }}</p></div>
            <div class="form-group"><label><strong>Logo:</strong></label><p>@if($marca->logo)<img src="{{ $marca->logo }}" height="50">@else - @endif</p></div>
            <div class="form-group"><label><strong>Sitio Web:</strong></label><p><a href="{{ $marca->sitio_web }}" target="_blank">{{ $marca->sitio_web ?: '-' }}</a></p></div>
            <div class="form-group"><label><strong>Activo:</strong></label><p>{!! $marca->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>' !!}</p></div>
            <a href="{{ route('admin.marcas.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop
