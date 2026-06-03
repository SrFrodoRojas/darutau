@extends('adminlte::page')

@section('title', 'Nuevo Estado de Venta')

@section('content_header')
    <h1>Nuevo Estado de Venta</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.estado-ventas.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="orden">Orden (opcional)</label>
                    <input type="number" name="orden" class="form-control @error('orden') is-invalid @enderror" value="{{ old('orden') }}">
                    <small class="form-text text-muted">Número que determina el orden en listados (menor número primero).</small>
                    @error('orden')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.estado-ventas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
