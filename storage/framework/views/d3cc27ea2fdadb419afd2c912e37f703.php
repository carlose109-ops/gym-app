

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="text-warning fw-bold mb-4">Finalizar Compra</h2>
    
    <div class="row">
        <div class="col-md-7">
            <div class="card bg-dark text-white border-warning mb-3">
                <div class="card-body">
                    <form action="<?php echo e(route('pago.procesar')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
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
                    <?php $total = 0; ?>
                    <?php $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $detalles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $total += $detalles['precio'] * $detalles['cantidad']; ?>
                        <div class="d-flex justify-content-between mb-2 small">
                            <span><?php echo e($detalles['imagen']); ?> <?php echo e($detalles['nombre']); ?> (x<?php echo e($detalles['cantidad']); ?>)</span>
                            <span class="text-warning">$<?php echo e(number_format($detalles['precio'] * $detalles['cantidad'], 2)); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <hr class="border-secondary">
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total a pagar:</span>
                        <span class="text-warning">$<?php echo e(number_format($total, 2)); ?> MXN</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.gym', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gabyr\Downloads\Proyecto web\Proyecto web\gym-app\resources\views/checkout.blade.php ENDPATH**/ ?>