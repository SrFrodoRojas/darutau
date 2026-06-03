@extends('adminlte::page')

@section('title', 'Stock por Depósito')

@section('content_header')
    <h1>Stock por Depósito</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <label>Depósito</label>
                    <select id="deposito_id" class="form-control">
                        @foreach($depositos as $dep)
                            <option value="{{ $dep->id }}" {{ $depositoId == $dep->id ? 'selected' : '' }}>{{ $dep->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 align-self-end">
                    <a href="{{ route('admin.stock.ajuste.form') }}" class="btn btn-warning">Ajuste Manual</a>
                </div>
                <div class="col-md-2 align-self-end">
                    <a href="{{ route('admin.stock.movimientos') }}" class="btn btn-info">Ver Movimientos</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Código</th>
                        <th>Stock Físico</th>
                        <th>Reservado</th>
                        <th>Disponible</th>
                        <th>Mínimo</th>
                        <th>Máximo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stock as $item)
                        <tr>
                            <td>{{ $item->producto->nombre }}</td>
                            <td>{{ $item->producto->codigo ?? '-' }}</td>
                            <td>{{ number_format($item->stock) }}</td>
                            <td>{{ number_format($item->stock_reservado) }}</td>
                            <td class="{{ ($item->stock - $item->stock_reservado) <= 0 ? 'text-danger' : 'text-success' }}">{{ number_format($item->stock - $item->stock_reservado) }}</td>
                            <td>{{ $item->stock_minimo ?? '-' }}</td>
                            <td>{{ $item->stock_maximo ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No hay stock registrado en este depósito.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
<script>
    $('#deposito_id').on('change', function() {
        let id = $(this).val();
        window.location.href = '{{ route("admin.stock.index") }}?deposito_id=' + id;
    });
</script>
@endsection
