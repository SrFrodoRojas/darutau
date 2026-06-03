@extends('adminlte::page')

@section('title', 'Editar Método de Pago')

@section('content_header')
    <h1>Editar Método de Pago</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.metodo-pagos.update', $metodoPago) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $metodoPago->nombre) }}" required>
                    @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="codigo">Código *</label>
                    <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo', $metodoPago->codigo) }}" required>
                    @error('codigo')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="requiere_referencia" name="requiere_referencia" value="1" {{ old('requiere_referencia', $metodoPago->requiere_referencia) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="requiere_referencia">Requiere número de referencia</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ old('activo', $metodoPago->activo) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activo">Activo</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.metodo-pagos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
