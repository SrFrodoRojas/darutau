@extends('adminlte::page')

@section('title', 'Nuevo Método de Pago')

@section('content_header')
    <h1>Nuevo Método de Pago</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.metodo-pagos.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="codigo">Código *</label>
                    <input type="text" name="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo') }}" required>
                    <small class="form-text text-muted">Ej: EFECTIVO, TARJETA_CREDITO, TRANSFERENCIA</small>
                    @error('codigo')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="requiere_referencia" name="requiere_referencia" value="1" {{ old('requiere_referencia') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="requiere_referencia">Requiere número de referencia (cheque, transferencia, etc.)</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activo">Activo</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.metodo-pagos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
