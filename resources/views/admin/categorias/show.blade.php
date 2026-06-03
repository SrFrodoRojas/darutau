@extends('adminlte::page')

@section('title', 'Ver Categoría')

@section('content_header')
    <h1>Ver Categoría</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label><strong>ID:</strong></label>
                <p>{{ $categoria->id }}</p>
            </div>
            <div class="form-group">
                <label><strong>Nombre:</strong></label>
                <p>{{ $categoria->nombre }}</p>
            </div>
            <div class="form-group">
                <label><strong>Descripción:</strong></label>
                <p>{{ $categoria->descripcion ?: '-' }}</p>
            </div>
            <div class="form-group">
                <label><strong>Activo:</strong></label>
                <p>{!! $categoria->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>' !!}</p>
            </div>
            <div class="form-group">
                <label><strong>Creado por:</strong></label>
                <p>{{ optional($categoria->creador)->name ?? 'N/A' }}</p>
            </div>
            <div class="form-group">
                <label><strong>Actualizado por:</strong></label>
                <p>{{ optional($categoria->actualizador)->name ?? 'N/A' }}</p>
            </div>
            <div class="form-group">
                <label><strong>Fecha creación:</strong></label>
                <p>{{ $categoria->created_at ? $categoria->created_at->format('d/m/Y H:i') : '-' }}</p>
            </div>
            <div class="form-group">
                <label><strong>Última actualización:</strong></label>
                <p>{{ $categoria->updated_at ? $categoria->updated_at->format('d/m/Y H:i') : '-' }}</p>
            </div>
            <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop
