@extends('adminlte::page')

@section('title', 'Editar Estado de Venta')

@section('content_header')
    <h1>Editar Estado de Venta</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.estado-ventas.update', $estadoVenta) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $estadoVenta->nombre) }}" required>
                    @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="orden">Orden</label>
                    <input type="number" name="orden" class="form-control @error('orden') is-invalid @enderror" value="{{ old('orden', $estadoVenta->orden) }}">
                    @error('orden')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.estado-ventas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
