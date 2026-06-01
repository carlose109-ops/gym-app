@extends('layouts.gym')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-warning">Panel de Administración - IronGym</h2>
        <div>
            <a href="{{ route('admin.usuarios') }}" class="btn btn-dark border-warning fw-bold px-4 me-2 text-white">👥 Ver Usuarios</a>
            <a href="{{ route('admin.productos.crear') }}" class="btn btn-warning fw-bold px-4">⚡ Agregar Nuevo Producto</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success bg-dark text-success border-success fw-bold text-center mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card bg-dark text-white border-secondary shadow">
        <div class="card-header border-secondary fw-bold text-warning fs-5 bg-black py-3">
            📦 Gestión de Inventario de Suplementos
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped align-middle m-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 90px;">Icono</th>
                            <th>Nombre del Producto</th>
                            <th>Marca</th>
                            <th>Categoría</th>
                            <th>Precio Público</th>
                            <th class="text-center" style="width: 220px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $id => $item)
                            <tr>
                                <td class="text-center fs-4">{{ $item['imagen'] }}</td>
                                <td class="fw-bold text-white">{{ $item['nombre'] }}</td>
                                <td class="text-secondary">{{ $item['marca'] }}</td>
                                <td><span class="badge bg-secondary text-warning px-2 py-1">{{ $item['cat'] }}</span></td>
                                <td class="text-warning fw-bold">${{ number_format($item['precio'], 2) }} MXN</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.productos.editar', $item['id']) }}" class="btn btn-outline-info btn-sm me-1">📝 Editar</a>
                                    <a href="{{ route('admin.productos.borrar', $item['id']) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Seguro que deseas borrar este producto del inventario?')">🗑️ Borrar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection