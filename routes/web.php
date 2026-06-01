<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes - IronGym (Estructura Corregida según Directorio Real)
|--------------------------------------------------------------------------
*/

// 1. Ruta de inicio (resources/views/welcome.blade.php)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rutas de Autenticación estándar de Laravel (Auth::routes)
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| 🌐 RUTAS DE AUTENTICACIÓN CON GOOGLE
|--------------------------------------------------------------------------
*/
Route::get('/login/google', function () {
    return Socialite::driver('google')->redirect();
})->name('login.google');

Route::get('/google-callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();
        
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => bcrypt(Str::random(16)),
            ]);
        } else if (!$user->google_id) {
            $user->update(['google_id' => $googleUser->id]);
        }

        Auth::login($user);
        return redirect('/');

    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Hubo un error al iniciar sesión con Google.');
    }
});

/*
|--------------------------------------------------------------------------
| 🛒 RUTAS DEL CARRITO DE COMPRAS Y CHECKOUT
|--------------------------------------------------------------------------
*/

// Vista del carrito (Apunta directo a resources/views/carrito.blade.php)
Route::get('/carrito', function () {
    $carrito = session()->get('carrito', []);
    return view('carrito', compact('carrito'));
})->name('carrito.index');

// Agregar productos o membresías al carrito
Route::post('/carrito/agregar/{id}', function (Request $request, $id) {
    $carrito = session()->get('carrito', []);

    // Datos simulados en memoria para los elementos añadidos
    $productosDisponibles = [
        1  => ['nombre' => 'Whey Protein Gold Standard', 'precio' => 1650, 'imagen' => '🥛'],
        2  => ['nombre' => 'ISO100 Hydrolyzed', 'precio' => 1890, 'imagen' => '🥛'],
        11 => ['nombre' => 'Plan Bronce 🥉', 'precio' => 350, 'imagen' => '💪'],
        22 => ['nombre' => 'Plan Iron Plata 🥈', 'precio' => 600, 'imagen' => '🏋️'],
        23 => ['nombre' => 'Plan Titan VIP 🥇', 'precio' => 900, 'imagen' => '👑']
    ];

    $producto = $productosDisponibles[$id] ?? ['nombre' => 'Suplemento Fitness', 'precio' => 500, 'imagen' => '📦'];

    if (isset($carrito[$id])) {
        $carrito[$id]['cantidad']++;
    } else {
        $carrito[$id] = [
            "nombre" => $producto['nombre'],
            "cantidad" => 1,
            "precio" => $producto['precio'],
            "imagen" => $producto['imagen']
        ];
    }

    session()->put('carrito', $carrito);
    return redirect()->back()->with('success', '¡Añadido al carrito con éxito!');
})->name('carrito.agregar');

// Vaciar carrito
Route::get('/carrito-vaciar', function () {
    session()->forget('carrito');
    return redirect()->route('carrito.index')->with('success', 'El carrito ha sido vaciado.');
})->name('carrito.vaciar');

// Checkout (Apunta directo a resources/views/checkout.blade.php)
Route::get('/finalizar-compra', function () {
    $carrito = session()->get('carrito', []);
    return view('checkout', compact('carrito'));
})->name('checkout');

// Procesar el pago final (Completamente simulado y libre de SMTP / Mailtrap)
Route::post('/procesar-pago', function (Request $request) {
    session()->forget('carrito');
    return redirect('/tienda')->with('success', '¡Pago exitoso! Tu pedido ha sido procesado de forma correcta.');
})->name('pago.procesar');

/*
|--------------------------------------------------------------------------
| Vistas Públicas de la aplicación (Mapeo de Rutas Directas)
|--------------------------------------------------------------------------
*/

// Tienda (Apunta directo a resources/views/tienda.blade.php)
Route::get('/tienda', function () {
    $productos = session()->get('admin_productos', [
        1 => ['id'=>1, 'nombre'=>'Whey Protein Gold Standard', 'marca'=>'Optimum Nutrition', 'precio'=>1650, 'cat'=>'Proteína', 'imagen'=>'🥛'],
        2 => ['id'=>2, 'nombre'=>'ISO100 Hydrolyzed', 'marca'=>'Dymatize', 'precio'=>1890, 'cat'=>'Proteína', 'imagen'=>'🥛']
    ]);
    return view('tienda', compact('productos'));
})->name('productos.index');

// Membresías (Apunta directo a resources/views/membresias.blade.php)
Route::get('/membresias', function () {
    return view('membresias');
})->name('membresias.index');

/*
|--------------------------------------------------------------------------
| Panel de Administración (Dentro de carpeta resources/views/admin/)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::get('/admin/productos/crear', [AdminController::class, 'create'])->name('admin.productos.crear');
    Route::post('/admin/productos/guardar', [AdminController::class, 'store'])->name('admin.productos.guardar');
    Route::get('/admin/productos/editar/{id}', [AdminController::class, 'edit'])->name('admin.productos.editar');
    Route::post('/admin/productos/actualizar/{id}', [AdminController::class, 'update'])->name('admin.productos.actualizar');
    Route::get('/admin/productos/borrar/{id}', [AdminController::class, 'destroy'])->name('admin.productos.borrar');
});