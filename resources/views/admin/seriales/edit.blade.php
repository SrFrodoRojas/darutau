@extends('adminlte::page')

@section('title', 'Editar Serial')

@section('content_header')
    <h1>Editar Serial: {{ $producto_serial->serial }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.seriales.update', $producto_serial) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="producto_id">Producto *</label>
                    <select name="producto_id" id="producto_id" class="form-control" required>
                        @foreach($productos as $prod)
                            <option value="{{ $prod->id }}" {{ old('producto_id', $producto_serial->producto_id) == $prod->id ? 'selected' : '' }}>{{ $prod->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="serial">Serial *</label>
                    <input type="text" name="serial" id="serial" class="form-control" value="{{ old('serial', $producto_serial->serial) }}" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado *</label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option value="disponible" {{ old('estado', $producto_serial->estado) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="vendido" {{ old('estado', $producto_serial->estado) == 'vendido' ? 'selected' : '' }}>Vendido</option>
                        <option value="devuelto" {{ old('estado', $producto_serial->estado) == 'devuelto' ? 'selected' : '' }}>Devuelto</option>
                        <option value="en_reparacion" {{ old('estado', $producto_serial->estado) == 'en_reparacion' ? 'selected' : '' }}>En reparación</option>
                        <option value="dado_baja" {{ old('estado', $producto_serial->estado) == 'dado_baja' ? 'selected' : '' }}>Dado de baja</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fecha_ingreso">Fecha Ingreso</label>
                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control" value="{{ old('fecha_ingreso', $producto_serial->fecha_ingreso) }}">
                </div>
                <div class="form-group">
                    <label for="fecha_vencimiento_garantia">Vencimiento Garantía</label>
                    <input type="date" name="fecha_vencimiento_garantia" id="fecha_vencimiento_garantia" class="form-control" value="{{ old('fecha_vencimiento_garantia', $producto_serial->fecha_vencimiento_garantia) }}">
                </div>
                <div class="form-group">
                    <label for="proveedor_id">Proveedor</label>
                    <select name="proveedor_id" id="proveedor_id" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach($proveedores as $prov)
                            <option value="{{ $prov->id }}" {{ old('proveedor_id', $producto_serial->proveedor_id) == $prov->id ? 'selected' : '' }}>{{ $prov->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="notas">Notas</label>
                    <textarea name="notas" id="notas" class="form-control">{{ old('notas', $producto_serial->notas) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('admin.seriales.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('#producto_id, #proveedor_id').select2({ theme: 'bootstrap4' });
</script>
@endsection
