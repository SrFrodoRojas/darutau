@extends('adminlte::page')
@section('title', 'Editar Impuesto')
@section('content_header')
    <h1>Editar Impuesto</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.impuestos.update', $impuesto) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $impuesto->nombre) }}" required>
                </div>
                <div class="form-group">
                    <label>Porcentaje (%)</label>
                    <input type="number" step="0.01" name="porcentaje" class="form-control" value="{{ old('porcentaje', $impuesto->porcentaje) }}" required>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ old('activo', $impuesto->activo) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activo">Activo</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.impuestos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
