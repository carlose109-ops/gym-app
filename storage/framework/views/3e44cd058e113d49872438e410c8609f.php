

<?php $__env->startSection('content'); ?>
<div class="container py-5 text-center">
    <h2 class="fw-bold text-warning mb-4">Elige tu plan de entrenamiento</h2>
    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show fw-bold text-start mx-auto" style="max-width: 800px;" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <div class="row justify-content-center g-4 mt-2">
        
        <div class="col-md-4">
            <div class="card bg-dark text-white border-secondary shadow h-100 p-3">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title text-uppercase text-secondary fw-bold">Plan Bronce</h3>
                    <h1 class="text-white my-4">$350 <span class="fs-5 text-secondary">/mes</span></h1>
                    <ul class="list-unstyled mb-4 text-start mx-auto">
                        <li class="mb-2">✔️ Área de pesas libres</li>
                        <li class="mb-2">✔️ Zona de cardio</li>
                        <li class="mb-2">✔️ Vestidores generales</li>
                        <li class="mb-2 text-secondary">❌ Clases grupales</li>
                        <li class="mb-2 text-secondary">❌ Asesoría nutricional</li>
                    </ul>
                    <form action="<?php echo e(route('carrito.agregar', 21)); ?>" method="POST" class="mt-auto w-100">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-light w-100 fw-bold">Elegir Bronce</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark text-white border-warning shadow-lg h-100 p-3 position-relative">
                <span class="badge bg-warning text-dark position-absolute top-0 start-50 translate-middle px-3 py-2 rounded-pill">MÁS POPULAR</span>
                <div class="card-body d-flex flex-column mt-3">
                    <h3 class="card-title text-uppercase text-warning fw-bold">Plan Iron</h3>
                    <h1 class="text-warning my-4">$500 <span class="fs-5 text-light">/mes</span></h1>
                    <ul class="list-unstyled mb-4 text-start mx-auto">
                        <li class="mb-2">✔️ Todas las áreas del gimnasio</li>
                        <li class="mb-2">✔️ Clases grupales (Spinning, Yoga)</li>
                        <li class="mb-2">✔️ Lockers personales</li>
                        <li class="mb-2">✔️ 1 Rutina personalizada al mes</li>
                        <li class="mb-2 text-secondary">❌ Asesoría nutricional</li>
                    </ul>
                    <form action="<?php echo e(route('carrito.agregar', 22)); ?>" method="POST" class="mt-auto w-100">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-warning text-dark w-100 fw-bold">Elegir Iron</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-dark text-white border-info shadow h-100 p-3">
                <div class="card-body d-flex flex-column">
                    <h3 class="card-title text-uppercase text-info fw-bold">Plan Titan VIP</h3>
                    <h1 class="text-info my-4">$900 <span class="fs-5 text-light">/mes</span></h1>
                    <ul class="list-unstyled mb-4 text-start mx-auto">
                        <li class="mb-2">✔️ Acceso total 24/7</li>
                        <li class="mb-2">✔️ Invitado gratis los fines de semana</li>
                        <li class="mb-2">✔️ Servicio de toallas y spa</li>
                        <li class="mb-2">✔️ Rutina personalizada quincenal</li>
                        <li class="mb-2">✔️ Cita mensual con Nutriólogo</li>
                    </ul>
                    <form action="<?php echo e(route('carrito.agregar', 23)); ?>" method="POST" class="mt-auto w-100">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-info w-100 fw-bold">Elegir Titan</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.gym', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gabyr\Downloads\Proyecto web\Proyecto web\gym-app\resources\views/membresias.blade.php ENDPATH**/ ?>