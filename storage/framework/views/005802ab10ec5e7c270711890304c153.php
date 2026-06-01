

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="fw-bold text-warning mb-4">Tu Carrito de Compras</h2>
    
    <?php if(count($carrito) > 0): ?>
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
                    <?php $total = 0; ?>
                    <?php $__currentLoopData = $carrito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $subtotal = $item['precio'] * $item['cantidad']; $total += $subtotal; ?>
                        <tr>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center bg-black border border-warning rounded mx-auto" style="width: 50px; height: 50px; font-size: 1.8rem;">
                                    <?php echo e($item['imagen'] ?? '📦'); ?>

                                </div>
                            </td>
                            <td><?php echo e($item['nombre']); ?></td>
                            <td>$<?php echo e(number_format($item['precio'], 2)); ?></td>
                            <td><?php echo e($item['cantidad']); ?></td>
                            <td class="fw-bold text-warning">$<?php echo e(number_format($subtotal, 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="<?php echo e(route('carrito.vaciar')); ?>" class="btn btn-outline-danger">Vaciar Carrito</a>
            <div class="text-end">
                <h4 class="text-white">Total a pagar: <span class="text-warning fw-bold">$<?php echo e(number_format($total, 2)); ?> MXN</span></h4>
                <a href="<?php echo e(route('checkout')); ?>" class="btn btn-warning btn-lg mt-2 fw-bold">Proceder al Pago</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-secondary text-center py-5">
            <h4>Tu carrito está vacío</h4>
            <p>Visita nuestra tienda para descubrir los mejores suplementos.</p>
            <a href="<?php echo e(route('productos.index')); ?>" class="btn btn-warning mt-3">Ir a la Tienda</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.gym', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gabyr\Downloads\Proyecto web\Proyecto web\gym-app\resources\views/carrito.blade.php ENDPATH**/ ?>