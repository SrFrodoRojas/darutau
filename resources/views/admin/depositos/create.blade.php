@extends('adminlte::page')

@section('title', 'Nuevo Depósito')

@section('content_header')
    <h1>Nuevo Depósito</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.depositos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="ubicacion">Ubicación</label>
                    <textarea name="ubicacion" id="ubicacion" class="form-control @error('ubicacion') is-invalid @enderror">{{ old('ubicacion') }}</textarea>
                    @error('ubicacion') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="responsable_id">Responsable</label>
                    <select name="responsable_id" id="responsable_id" class="form-control @error('responsable_id') is-invalid @enderror">
                        <option value="">Seleccione un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsable_id') == $usuario->id ? 'selected' : '' }}>{{ $usuario->name }}</option>
                        @endforeach
                    </select>
                    @error('responsable_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="activo" class="custom-control-input" id="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activo">Activo</label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('admin.depositos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    // Select2 para responsable
    $('#responsable_id').select2({ theme: 'bootstrap4' });
</script>
@endsection
