<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AdminController;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes - IronGym
|--------------------------------------------------------------------------
*/

// Ruta de inicio
Route::get('/', function () {
    return view('welcome');
});

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
| Rutas del Carrito y Procesamiento de Pago (Simulado)
|--------------------------------------------------------------------------
*/

// Vista del carrito de compras
Route::get('/carrito', function () {
    $carrito = session()->get('carrito', []);
    return view('carrito.index', compact('carrito'));
})->name('carrito.index');

// Procesar el pago de la compra (CORREGIDO EL ->name('pago.procesar'))
Route::post('/procesar-pago', function (Request $request) {
    $carrito = session()->get('carrito', []);
    $direccion = $request->direccion;
    $usuario = Auth::user();

    // 🚫 SE MANTIENE COMENTADO EL ENVÍO DE CORREO PARA EVITAR EL ERROR 500 EN RAILWAY
    /*
    Mail::send('emails.recibo', ['carrito' => $carrito, 'direccion' => $direccion], function ($mensaje) use ($usuario) {
        $mensaje->to($usuario->email, $usuario->name)
                ->subject('Recibo de tu compra en IronGym');
    });
    */

    session()->forget('carrito');

    return redirect('/tienda')->with('success', '¡Pago exitoso! Tu pedido ha sido procesado de forma correcta.');
})->name('pago.procesar'); // <--- CORRECCIÓN CLAVE: El nombre original exacto que tus Blade buscan

/*
|--------------------------------------------------------------------------
| Rutas de la Tienda y Membresías (Vistas base)
|--------------------------------------------------------------------------
*/
Route::get('/tienda', function () {
    $productos = session()->get('admin_productos', [
        1 => ['id'=>1, 'nombre'=>'Whey Protein Gold Standard', 'marca'=>'Optimum Nutrition', 'precio'=>1650, 'cat'=>'Proteína', 'imagen'=>'🥛'],
        2 => ['id'=>2, 'nombre'=>'ISO100 Hydrolyzed', 'marca'=>'Dymatize', 'precio'=>1890, 'cat'=>'Proteína', 'imagen'=>'🥛']
    ]);
    return view('productos.index', compact('productos'));
})->name('productos.index');

Route::get('/membresias', function () {
    return view('membresias.index');
})->name('membresias.index');

/*
|--------------------------------------------------------------------------
| Rutas del Panel de Administración (Controladas por AdminController)
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