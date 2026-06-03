@extends('adminlte::page')

@section('title', 'Nueva Marca')

@section('content_header')
    <h1>Nueva Marca</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.marcas.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror">{{ old('descripcion') }}</textarea>
                    @error('descripcion')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="logo">Logo (URL)</label>
                    <input type="text" name="logo" class="form-control @error('logo') is-invalid @enderror" value="{{ old('logo') }}">
                    @error('logo')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="sitio_web">Sitio Web</label>
                    <input type="url" name="sitio_web" class="form-control @error('sitio_web') is-invalid @enderror" value="{{ old('sitio_web') }}">
                    @error('sitio_web')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activo">Activo</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('admin.marcas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop
