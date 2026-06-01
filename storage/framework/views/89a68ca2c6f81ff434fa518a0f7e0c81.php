<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IronGym - UAEMéx</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom { background-color: #1a1a1a; }
        .hero-section { background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1517838277536-f5f99be501cd?q=80&w=1000') no-repeat center center/cover; color: white; padding: 100px 0; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="<?php echo e(url('/')); ?>">IRON GYM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(url('/')); ?>">Inicio</a></li>
                    
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('membresias.index')); ?>">Membresías</a></li>
                    
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('productos.index')); ?>">Tienda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('carrito.index')); ?>">Carrito 🛒</a></li>
                    
                    <?php if(Auth::check() && Auth::user()->email === 'gabyrebal23@gmail.com'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning fw-bold" href="<?php echo e(route('admin.index')); ?>">Panel Administrador ⚙️</a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-warning btn-sm ms-2 text-white" href="<?php echo e(route('login')); ?>">Iniciar Sesión</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn btn-outline-warning btn-sm ms-2 text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <?php echo e(Auth::user()->name); ?>

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-item text-danger">Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid p-0">
        <?php if(session('error')): ?>
            <div class="alert alert-danger text-center fw-bold m-0 rounded-0 border-0 shadow-sm" style="background-color: #dc3545; color: white;">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p class="mb-0">&copy; 2026 IronGym - Ingeniería en Software UAEMéx</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\Users\gabyr\Downloads\Proyecto web\Proyecto web\gym-app\resources\views/layouts/gym.blade.php ENDPATH**/ ?>