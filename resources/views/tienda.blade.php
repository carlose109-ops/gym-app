@extends('layouts.gym')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-warning mb-4">Tienda de Suplementos</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @foreach($productos as $producto)
        <div class="col-md-3">
            <div class="card bg-dark text-white border-warning shadow h-100">
                <div class="d-flex align-items-center justify-content-center bg-black border-bottom border-warning" style="height: 180px; font-size: 4.5rem; background: linear-gradient(135deg, #212529 0%, #111111 100%);">
                    {{ $producto['imagen'] }}
                </div>
                
                <div class="card-body text-center d-flex flex-column">
                    <span class="badge bg-secondary mb-2">{{ $producto['cat'] }}</span>
                    <h5 class="card-title fw-bold small">{{ $producto['nombre'] }}</h5>
                    <p class="card-text text-light-50 small" style="font-size: 0.8rem;">{{ $producto['marca'] }}</p>
                    <h4 class="text-warning mt-auto">${{ number_format($producto['precio'], 2) }} MXN</h4>
                    
                    <form action="{{ route('carrito.agregar', $producto['id']) }}" method="POST" class="mt-3">
                        @csrf 
                        <button type="submit" class="btn btn-outline-warning w-100">Agregar al Carrito 🛒</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection