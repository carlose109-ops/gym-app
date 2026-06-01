<?php $__env->startSection('content'); ?>
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="display-3 fw-bold text-warning">ENTRENA SIN LÍMITES</h1>
            <p class="lead text-white-50">Tu salud y rendimiento son nuestra prioridad. Gestión completa de membresías y suplementación.</p>
            <a href="<?php echo e(route('membresias.index')); ?>" class="btn btn-warning btn-lg fw-bold px-4 py-2 mt-3">Ver Planes</a>
        </div>
    </div>

    <div class="container my-5">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h3>Membresías</h3>
                    <p>Control de accesos y mensualidades automatizadas.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h3>Tienda Fit</h3>
                    <p>Carrito de compras integrado para suplementos alimenticios.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow-sm">
                    <h3>Pagos Seguros</h3>
                    <p>Pasarela externa con notificaciones instantáneas.</p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.gym', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gabyr\Downloads\Proyecto web\Proyecto web\gym-app\resources\views/welcome.blade.php ENDPATH**/ ?>