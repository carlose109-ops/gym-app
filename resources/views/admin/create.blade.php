@extends('layouts.gym')

@section('content')
<div class="container py-5" style="max-width: 750px;">
    <div class="mb-4">
        <a href="{{ route('admin.index') }}" class="text-warning text-decoration-none fw-bold">← Volver al Panel de Control</a>
    </div>

    <div class="card bg-dark text-white border-warning shadow-lg">
        <div class="card-header border-warning text-center bg-black py-3">
            <h3 class="fw-bold text-warning my-1">
                {{ isset($producto) ? 'Editar Suplemento' : 'Registrar Nuevo Suplemento' }}
            </h3>
        </div>
        <div class="card-body p-4">
            <form action="{{ isset($producto) ? route('admin.productos.actualizar', $producto['id']) : route('admin.productos.guardar') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-bold text-warning">Nombre del Producto</label>
                        <input type="text" class="form-control bg-secondary text-white border-0 py-2" placeholder="Ej. ISO100 Hydrolyzed" name="nombre" value="{{ $producto['nombre'] ?? '' }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold text-warning">Emoji / Icono</label>
                        <input type="text" class="form-control bg-secondary text-white border-0 text-center py-2" placeholder="Ej. 🥛 o 🧪" name="imagen" value="{{ $producto['imagen'] ?? '' }}" maxlength="2" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-warning">Marca</label>
                        <input type="text" class="form-control bg-secondary text-white border-0 py-2" placeholder="Ej. Dymatize" name="marca" value="{{ $producto['marca'] ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold text-warning">Categoría del Suplemento</label>
                        <select class="form-select bg-secondary text-white border-0 py-2" name="cat" required>
                            <option value="Proteína" {{ (isset($producto) && $producto['cat'] == 'Proteína') ? 'selected' : '' }}>Proteína</option>
                            <option value="Pre-entreno" {{ (isset($producto) && $producto['cat'] == 'Pre-entreno') ? 'selected' : '' }}>Pre-entreno</option>
                            <option value="Creatina" {{ (isset($producto) && $producto['cat'] == 'Creatina') ? 'selected' : '' }}>Creatina</option>
                            <option value="Aminoácidos" {{ (isset($producto) && $producto['cat'] == 'Aminoácidos') ? 'selected' : '' }}>Aminoácidos</option>
                            <option value="Barras" {{ (isset($producto) && $producto['cat'] == 'Barras') ? 'selected' : '' }}>Barras / Snacks</option>
                            <option value="Accesorios" {{ (isset($producto) && $producto['cat'] == 'Accesorios') ? 'selected' : '' }}>Accesorios de Gimnasio</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-warning">Precio de Venta (MXN)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-secondary text-warning border-0 fw-bold">$</span>
                        <input type="number" class="form-control bg-secondary text-white border-0 py-2" placeholder="0.00" name="precio" value="{{ $producto['precio'] ?? '' }}" min="1" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning w-100 fw-bold fs-5 py-2 shadow shadow-sm">
                    {{ isset($producto) ? 'Actualizar Producto' : 'Guardar Producto en Sistema' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection