<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\AdminController;

// ==========================================
// 1. RUTAS DE AUTENTICACIÓN Y GOOGLE
// ==========================================
Auth::routes();

Route::get('/login-google', [GoogleLoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/google-callback', [GoogleLoginController::class, 'handleGoogleCallback']);

// ==========================================
// 2. CATÁLOGO DE PRODUCTOS (Simulación)
// ==========================================
$productos = [
    1 => ['id'=>1, 'nombre'=>'Whey Protein Gold Standard', 'marca'=>'Optimum Nutrition', 'precio'=>1650, 'cat'=>'Proteína', 'imagen'=>'🥛'],
    2 => ['id'=>2, 'nombre'=>'ISO100 Hydrolyzed', 'marca'=>'Dymatize', 'precio'=>1890, 'cat'=>'Proteína', 'imagen'=>'🥛'],
    3 => ['id'=>3, 'nombre'=>'Nitro-Tech 100% Whey', 'marca'=>'MuscleTech', 'precio'=>1450, 'cat'=>'Proteína', 'imagen'=>'🥛'],
    4 => ['id'=>4, 'nombre'=>'Carnivor Beef Protein', 'marca'=>'MuscleMeds', 'precio'=>1300, 'cat'=>'Proteína', 'imagen'=>'🥛'],
    5 => ['id'=>5, 'nombre'=>'C4 Original', 'marca'=>'Cellucor', 'precio'=>650, 'cat'=>'Pre-entreno', 'imagen'=>'⚡'],
    6 => ['id'=>6, 'nombre'=>'Psychotic', 'marca'=>'Insane Labz', 'precio'=>750, 'cat'=>'Pre-entreno', 'imagen'=>'⚡'],
    7 => ['id'=>7, 'nombre'=>'N.O.-Xplode', 'marca'=>'BSN', 'precio'=>800, 'cat'=>'Pre-entreno', 'imagen'=>'⚡'],
    8 => ['id'=>8, 'nombre'=>'Creatina Monohidratada', 'marca'=>'Platinum', 'precio'=>550, 'cat'=>'Creatina', 'imagen'=>'🧪'],
    9 => ['id'=>9, 'nombre'=>'Creatine Drive', 'marca'=>'Nutrex', 'precio'=>600, 'cat'=>'Creatina', 'imagen'=>'🧪'],
    10=> ['id'=>10, 'nombre'=>'Xtend BCAA', 'marca'=>'Scivation', 'precio'=>700, 'cat'=>'Aminoácidos', 'imagen'=>'🧬'],
    11=> ['id'=>11, 'nombre'=>'Amino Energy', 'marca'=>'Optimum Nutrition', 'precio'=>680, 'cat'=>'Aminoácidos', 'imagen'=>'🧬'],
    12=> ['id'=>12, 'nombre'=>'Quest Protein Bar (Caja x12)', 'marca'=>'Quest Nutrition', 'precio'=>850, 'cat'=>'Barras', 'imagen'=>'🍫'],
    13=> ['id'=>13, 'nombre'=>'One Bar Peanut Butter (Caja x12)', 'marca'=>'One Brands', 'precio'=>800, 'cat'=>'Barras', 'imagen'=>'🍫'],
    14=> ['id'=>14, 'nombre'=>'The Complete Cookie (Caja x12)', 'marca'=>'Lenny & Larrys', 'precio'=>750, 'cat'=>'Snacks', 'imagen'=>'🍪'],
    15=> ['id'=>15, 'nombre'=>'L-Carnitine 3000', 'marca'=>'GAT Sport', 'precio'=>450, 'cat'=>'Quemadores', 'imagen'=>'🔥'],
    16=> ['id'=>16, 'nombre'=>'Multivitamínico Opti-Men', 'marca'=>'Optimum Nutrition', 'precio'=>500, 'cat'=>'Vitaminas', 'imagen'=>'💊'],
    17=> ['id'=>17, 'nombre'=>'Multivitamínico Opti-Women', 'marca'=>'Optimum Nutrition', 'precio'=>500, 'cat'=>'Vitaminas', 'imagen'=>'💊'],
    18=> ['id'=>18, 'nombre'=>'Shaker BlenderBottle 28oz', 'marca'=>'Iron Gym', 'precio'=>250, 'cat'=>'Accesorios', 'imagen'=>'🥤'],
    19=> ['id'=>19, 'nombre'=>'Straps para Levantamiento', 'marca'=>'Iron Gym', 'precio'=>200, 'cat'=>'Accesorios', 'imagen'=>'💪'],
    20=> ['id'=>20, 'nombre'=>'Cinturón de Halterofilia de Cuero', 'marca'=>'Iron Gym', 'precio'=>950, 'cat'=>'Accesorios', 'imagen'=>'🪨'],

    // MEMBRESÍAS
    21=> ['id'=>21, 'nombre'=>'Membresía Plan Bronce (1 Mes)', 'marca'=>'IronGym', 'precio'=>350, 'cat'=>'Membresía', 'imagen'=>'🥉'],
    22=> ['id'=>22, 'nombre'=>'Membresía Plan Iron (1 Mes)', 'marca'=>'IronGym', 'precio'=>500, 'cat'=>'Membresía', 'imagen'=>'🥇'],
    23=> ['id'=>23, 'nombre'=>'Membresía Plan Titan VIP (1 Mes)', 'marca'=>'IronGym', 'precio'=>900, 'cat'=>'Membresía', 'imagen'=>'💎'],
];

// ==========================================
// 3. RUTAS PÚBLICAS
// ==========================================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/membresias', function () {
    return view('membresias');
})->name('membresias.index');

Route::get('/tienda', function () use ($productos) {
    return view('tienda', ['productos' => $productos]);
})->name('productos.index');

// ==========================================
// 4. RUTAS PROTEGIDAS (requieren autenticación)
// ==========================================
Route::middleware(['auth'])->group(function () use ($productos) {
    
    // ---- CARRITO ----
    Route::get('/carrito', function () {
        $carrito = session()->get('carrito', []);
        return view('carrito', ['carrito' => $carrito]);
    })->name('carrito.index');

    Route::post('/carrito/agregar/{id}', function (Request $request, $id) use ($productos) {
        $carrito = session()->get('carrito', []);
        if (isset($productos[$id])) {
            if (isset($carrito[$id])) {
                $carrito[$id]['cantidad']++;
            } else {
                $carrito[$id] = [
                    'nombre'   => $productos[$id]['nombre'],
                    'precio'   => $productos[$id]['precio'],
                    'imagen'   => $productos[$id]['imagen'],
                    'cantidad' => 1
                ];
            }
            session()->put('carrito', $carrito);
        }
        return redirect()->back()->with('success', '¡' . $productos[$id]['nombre'] . ' agregado al carrito!');
    })->name('carrito.agregar');

    Route::get('/carrito/vaciar', function () {
        session()->forget('carrito');
        return redirect()->route('carrito.index');
    })->name('carrito.vaciar');

    // ---- PAGO Y CORREO ----
    Route::get('/checkout', function () {
        $carrito = session()->get('carrito', []);
        if (empty($carrito)) return redirect()->route('carrito.index');
        return view('checkout', compact('carrito'));
    })->name('checkout');

    Route::post('/procesar-pago', function (Request $request) {
        $carrito = session()->get('carrito', []);
        $direccion = $request->direccion;
        $usuario = Auth::user();

        Mail::send('emails.recibo', ['carrito' => $carrito, 'direccion' => $direccion], function ($mensaje) use ($usuario) {
            $mensaje->to($usuario->email, $usuario->name)
                    ->subject('Recibo de tu compra en IronGym');
        });

        session()->forget('carrito');
        return redirect('/tienda')->with('success', '¡Pago exitoso! Hemos enviado tu recibo por correo electrónico.');
    })->name('pago.procesar');

    // ---- ADMINISTRADOR (CRUD) ----
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/productos/crear', [AdminController::class, 'create'])->name('admin.productos.crear');
    Route::post('/admin/productos/guardar', [AdminController::class, 'store'])->name('admin.productos.guardar');
    Route::get('/admin/productos/{id}/editar', [AdminController::class, 'edit'])->name('admin.productos.editar');
    Route::post('/admin/productos/{id}/actualizar', [AdminController::class, 'update'])->name('admin.productos.actualizar');
    Route::get('/admin/productos/{id}/borrar', [AdminController::class, 'destroy'])->name('admin.productos.borrar');
    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
});