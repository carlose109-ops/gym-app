

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="fw-bold text-warning mb-4">Tienda de Suplementos</h2>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-3">
            <div class="card bg-dark text-white border-warning shadow h-100">
                <div class="d-flex align-items-center justify-content-center bg-black border-bottom border-warning" style="height: 180px; font-size: 4.5rem; background: linear-gradient(135deg, #212529 0%, #111111 100%);">
                    <?php echo e($producto['imagen']); ?>

                </div>
                
                <div class="card-body text-center d-flex flex-column">
                    <span class="badge bg-secondary mb-2"><?php echo e($producto['cat']); ?></span>
                    <h5 class="card-title fw-bold small"><?php echo e($producto['nombre']); ?></h5>
                    <p class="card-text text-light-50 small" style="font-size: 0.8rem;"><?php echo e($producto['marca']); ?></p>
                    <h4 class="text-warning mt-auto">$<?php echo e(number_format($producto['precio'], 2)); ?> MXN</h4>
                    
                    <form action="<?php echo e(route('carrito.agregar', $producto['id'])); ?>" method="POST" class="mt-3">
                        <?php echo csrf_field(); ?> 
                        <button type="submit" class="btn btn-outline-warning w-100">Agregar al Carrito 🛒</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.gym', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gabyr\Downloads\Proyecto web\Proyecto web\gym-app\resources\views/tienda.blade.php ENDPATH**/ ?>