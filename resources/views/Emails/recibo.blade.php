<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .caja { background-color: #ffffff; padding: 20px; border-radius: 8px; max-width: 500px; margin: auto; }
        .header { background-color: #212529; color: #ffc107; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; font-size: 24px; font-weight: bold;}
        .total { font-size: 20px; font-weight: bold; color: #d9534f; margin-top: 15px;}
    </style>
</head>
<body>
    <div class="caja">
        <div class="header">IRON GYM</div>
        <p>Hola <strong>{{ $userName }}</strong>,</p> 
        <p>¡Gracias por tu compra! Hemos recibido tu pedido y lo estamos procesando.</p>
        
        <h3>Detalles de tu orden:</h3>
        <ul>
            @php $total = 0; @endphp
            @foreach($carrito as $item)
                @php $total += $item['precio'] * $item['cantidad']; @endphp
                <li>{{ $item['nombre'] }} (x{{ $item['cantidad'] }}) - ${{ number_format($item['precio'] * $item['cantidad'], 2) }} MXN</li>
            @endforeach
        </ul>
        
        <p><strong>Dirección de envío:</strong> {{ $direccion }}</p>
        
        <div class="total">Total Pagado: ${{ number_format($total, 2) }} MXN</div>
        
        <hr style="border: 0; border-top: 1px solid #ccc; margin-top: 20px;">
        <p style="font-size: 12px; color: #777; text-align: center;">Este es un correo automático, por favor no respondas a este mensaje.</p>
    </div>
</body>
</html>