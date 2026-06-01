@extends('layouts.gym')

@section('content')
<div class="container py-5">
    <h2 class="text-warning fw-bold mb-4">Finalizar Compra</h2>
    
    <div class="row">
        <div class="col-md-7">
            <div class="card bg-dark text-white border-warning mb-3">
                <div class="card-body">
                    <form action="{{ route('pago.procesar') }}" method="POST">
                        @csrf
                        <h4 class="text-warning mb-3">Datos de Envío</h4>
                        <div class="mb-3">
                            <label class="form-label">Dirección Completa</label>
                            <input type="text" class="form-control bg-secondary text-white border-0" name="direccion" required>
                        </div>
                        
                        <h4 class="text-warning mb-3 mt-4">Método de Pago</h4>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="metodo_pago" value="tarjeta" id="pago1" checked>
                            <label class="form-check-label" for="pago1">
                                💳 Tarjeta de Crédito / Débito
                            </label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="metodo_pago" value="efectivo" id="pago2">
                            <label class="form-check-label" for="pago2">
                                🏪 Pago en Efectivo (Generar voucher para OXXO/Practicaja)
                            </label>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold fs-5">Confirmar y Pagar</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card bg-dark text-white border-secondary">
                <div class="card-header border-secondary text-center">Resumen de tu Orden</div>
                <div class="card-body">
                    @php $total = 0; @endphp
                    @foreach($carrito as $id => $detalles)
                        @php $total += $detalles['precio'] * $detalles['cantidad']; @endphp
                        <div class="d-flex justify-content-between mb-2 small">
                            <span>{{ $detalles['imagen'] }} {{ $detalles['nombre'] }} (x{{ $detalles['cantidad'] }})</span>
                            <span class="text-warning">${{ number_format($detalles['precio'] * $detalles['cantidad'], 2) }}</span>
                        </div>
                    @endforeach
                    <hr class="border-secondary">
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total a pagar:</span>
                        <span class="text-warning">${{ number_format($total, 2) }} MXN</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection