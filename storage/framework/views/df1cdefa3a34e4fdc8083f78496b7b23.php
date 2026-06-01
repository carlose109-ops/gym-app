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
        <p>Hola <strong><?php echo e(Auth::user()->name); ?></strong>,</p>
        <p>¡Gracias por tu compra! Hemos recibido tu pedido y lo estamos procesando.</p>
        
        <h3>Detalles de tu orden:</h3>
        <ul>
            <?php $total = 0; ?>
            <?php $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $total += $item['precio'] * $item['cantidad']; ?>
                <li><?php echo e($item['nombre']); ?> (x<?php echo e($item['cantidad']); ?>) - $<?php echo e(number_format($item['precio'] * $item['cantidad'], 2)); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        
        <p class="total">Total pagado: $<?php echo e(number_format($total, 2)); ?> MXN</p>
        
        <p>Tu pedido será enviado a: <em><?php echo e($direccion); ?></em></p>
        
        <p>Si elegiste pago en efectivo, recuerda presentar tu número de orden en tu sucursal más cercana.</p>
        <p>¡Sigue entrenando sin límites!</p>
    </div>
</body>
</html><?php /**PATH C:\Users\gabyr\Downloads\Proyecto web\Proyecto web\gym-app\resources\views/emails/recibo.blade.php ENDPATH**/ ?>