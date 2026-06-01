

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-warning">Control de Miembros Registrados</h2>
        <a href="<?php echo e(route('admin.index')); ?>" class="btn btn-secondary fw-bold px-4">Volver al Inventario</a>
    </div>

    <div class="card bg-dark text-white border-secondary shadow">
        <div class="card-header border-secondary fw-bold text-warning fs-5 bg-black py-3">
            👥 Usuarios de IronGym
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped align-middle m-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Correo Electrónico</th>
                            <th>Fecha de Registro</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-bold text-secondary">#<?php echo e($user->id); ?></td>
                                <td class="fw-bold text-white"><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                                <td class="text-center"><span class="badge bg-success">Activo</span></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.gym', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\gabyr\Downloads\Proyecto web\Proyecto web\gym-app\resources\views/admin/usuarios.blade.php ENDPATH**/ ?>