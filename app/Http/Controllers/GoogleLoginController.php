<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;

class GoogleLoginController extends Controller
{
    /**
     * Redirecciona al usuario a la página de autenticación de Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirectUrl(url('/google-callback'))
            ->redirect();
    }

    /**
     * Maneja la respuesta del callback de Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(url('/google-callback'))
                ->user();

            // 1. Buscar o crear el usuario
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->redirectUrl(url('/google-callback'))
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl(url('/google-callback'))
                ->user();

            // Buscar o crear usuario
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => Hash::make('password123'), // o un generador aleatorio
                ]);
            } else {
                // Si ya existe pero no tiene google_id, actualízalo
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }
            }

            // Iniciar sesión
            Auth::login($user);

            // Lista de administradores (mejor mantenerla en un solo lugar, por ejemplo en config/admin.php)
            $admins = ['carloseduardot109@gmail.com', 'gabyrebal23@gmail.com'];

            // Redirigir según el rol
            if (in_array($user->email, $admins)) {
                return redirect()->route('admin.index')->with('success', 'Bienvenido al panel de administración.');
            }

            return redirect('/')->with('success', 'Has iniciado sesión correctamente.');

        } catch (Exception $e) {
            // Registrar el error en el log para depuración (opcional)
            \Log::error('Error en login con Google: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Hubo un problema al iniciar sesión con Google. Inténtalo de nuevo.');
        }
    }
}