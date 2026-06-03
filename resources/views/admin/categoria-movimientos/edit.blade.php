@extends('adminlte::page')

@section('title', 'Editar Categoría de Movimiento')

@section('content_header')
    <h1>Editar Categoría de Movimiento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.categoria-movimientos.update', $categoriaMovimiento) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $categoriaMovimiento->nombre) }}" required>
                    @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo *</label>
                    <select name="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                        <option value="ingreso" {{ old('tipo', $categoriaMovimiento->tipo) == 'ingreso' ? 'selected' : '' }}>Ingreso</option>
                        <option value="egreso" {{ old('tipo', $categoriaMovimiento->tipo) == 'egreso' ? 'selected' : '' }}>Egreso</option>
                    </select>
                    @error('tipo')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ old('activo', $categoriaMovimiento->activo) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activo">Activo</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.categoria-movimientos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
