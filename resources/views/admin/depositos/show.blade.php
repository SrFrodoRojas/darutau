@extends('adminlte::page')

@section('title', 'Detalle Depósito')

@section('content_header')
    <h1>Depósito: {{ $deposito->nombre }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>ID</th><td>{{ $deposito->id }}</td></tr>
                <tr><th>Nombre</th><td>{{ $deposito->nombre }}</td></tr>
                <tr><th>Ubicación</th><td>{{ $deposito->ubicacion ?: 'N/A' }}</td></tr>
                <tr><th>Responsable</th><td>{{ $deposito->responsable->name ?? 'Ninguno' }}</td></tr>
                <tr><th>Activo</th><td>{!! $deposito->activo ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-danger">No</span>' !!}</td></tr>
                <tr><th>Creado</th><td>{{ $deposito->created_at }}</td></tr>
                <tr><th>Actualizado</th><td>{{ $deposito->updated_at }}</td></tr>
            </table>
            <a href="{{ route('admin.depositos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@endsection
