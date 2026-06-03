@extends('adminlte::page')

@section('title', 'Nuevo Producto')

@section('content_header')
    <h1>Nuevo Producto</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.productos.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{ old('codigo') }}">
                            @error('codigo') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="codigo_barras">Código de Barras</label>
                            <input type="text" name="codigo_barras" id="codigo_barras" class="form-control" value="{{ old('codigo_barras') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="categoria_id">Categoría</label>
                            <select name="categoria_id" id="categoria_id" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="marca_id">Marca</label>
                            <select name="marca_id" id="marca_id" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca->id }}" {{ old('marca_id') == $marca->id ? 'selected' : '' }}>{{ $marca->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio_compra">Precio Compra (Gs.)</label>
                            <input type="number" name="precio_compra" id="precio_compra" class="form-control" value="{{ old('precio_compra', 0) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="precio_venta">Precio Venta (Gs.) *</label>
                            <input type="number" name="precio_venta" id="precio_venta" class="form-control @error('precio_venta') is-invalid @enderror" value="{{ old('precio_venta', 0) }}" required>
                            @error('precio_venta') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="unidad_medida">Unidad Medida</label>
                            <input type="text" name="unidad_medida" id="unidad_medida" class="form-control" value="{{ old('unidad_medida', 'unidad') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="peso_gramos">Peso (gramos)</label>
                            <input type="number" name="peso_gramos" id="peso_gramos" class="form-control" value="{{ old('peso_gramos') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="impuesto_id">Impuesto</label>
                            <select name="impuesto_id" id="impuesto_id" class="form-control">
                                <option value="">Ninguno</option>
                                @foreach($impuestos as $imp)
                                    <option value="{{ $imp->id }}" {{ old('impuesto_id') == $imp->id ? 'selected' : '' }}>{{ $imp->nombre }} ({{ $imp->porcentaje }}%)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="activo" class="custom-control-input" id="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="activo">Activo</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="destacado" class="custom-control-input" id="destacado" value="1" {{ old('destacado') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="destacado">Destacado en web</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="usa_serial" class="custom-control-input" id="usa_serial" value="1" {{ old('usa_serial') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="usa_serial">Usa número de serie</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="mostrar_web" class="custom-control-input" id="mostrar_web" value="1" {{ old('mostrar_web', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="mostrar_web">Mostrar en web</label>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" name="precio_incluye_iva" class="custom-control-input" id="precio_incluye_iva" value="1" {{ old('precio_incluye_iva') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="precio_incluye_iva">Precio incluye IVA</label>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('#categoria_id, #marca_id, #impuesto_id').select2({ theme: 'bootstrap4' });
</script>
@endsection
