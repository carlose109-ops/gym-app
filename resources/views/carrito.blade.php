@extends('layouts.gym')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-warning mb-4">Tu Carrito de Compras</h2>
    
    @if(count($carrito) > 0)
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 100px;">Producto</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($carrito as $id => $item)
                        @php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; @endphp
                        <tr>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center bg-black border border-warning rounded mx-auto" style="width: 50px; height: 50px; font-size: 1.8rem;">
                                    {{ $item['imagen'] ?? '📦' }}
                                </div>
                            </td>
                            <td>{{ $item['nombre'] }}</td>
                            <td>${{ number_format($item['precio'], 2) }}</td>
                            <td>{{ $item['cantidad'] }}</td>
                            <td class="fw-bold text-warning">${{ number_format($subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('carrito.vaciar') }}" class="btn btn-outline-danger">Vaciar Carrito</a>
            <div class="text-end">
                <h4 class="text-white">Total a pagar: <span class="text-warning fw-bold">${{ number_format($total, 2) }} MXN</span></h4>
                <a href="{{ route('checkout') }}" class="btn btn-warning btn-lg mt-2 fw-bold">Proceder al Pago</a>
            </div>
        </div>
    @else
        <div class="alert alert-secondary text-center py-5">
            <h4>Tu carrito está vacío</h4>
            <p>Visita nuestra tienda para descubrir los mejores suplementos.</p>
            <a href="{{ route('productos.index') }}" class="btn btn-warning mt-3">Ir a la Tienda</a>
        </div>
    @endif
</div>
@endsection