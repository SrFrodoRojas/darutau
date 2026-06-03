@extends('adminlte::page')
@section('title', 'Nuevo Impuesto')
@section('content_header')
    <h1>Nuevo Impuesto</h1>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.impuestos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="porcentaje">Porcentaje (%) *</label>
                    <input type="number" step="0.01" name="porcentaje" class="form-control" required>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" checked>
                        <label class="custom-control-label" for="activo">Activo</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.impuestos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
