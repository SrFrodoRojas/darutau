@extends('adminlte::page')

@section('title', 'Ajuste Manual de Stock')

@section('content_header')
    <h1>Ajuste Manual de Stock</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.stock.ajuste.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="producto_id">Producto *</label>
                    <select name="producto_id" id="producto_id" class="form-control" required>
                        <option value="">Seleccione un producto</option>
                        @foreach($productos as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->nombre }} ({{ $prod->codigo ?? 'sin código' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="deposito_id">Depósito *</label>
                    <select name="deposito_id" id="deposito_id" class="form-control" required>
                        <option value="">Seleccione un depósito</option>
                        @foreach($depositos as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad *</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" required placeholder="Ej: +10 (aumentar) o -5 (disminuir)">
                    <small class="text-muted">Usa signo positivo para entrada, negativo para salida</small>
                </div>
                <div class="form-group">
                    <label for="motivo">Motivo *</label>
                    <textarea name="motivo" id="motivo" class="form-control" rows="2" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Aplicar Ajuste</button>
                    <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('#producto_id, #deposito_id').select2({ theme: 'bootstrap4' });
</script>
@endsection
