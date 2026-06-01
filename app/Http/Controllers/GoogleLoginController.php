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
                    'google_id' => $googleUser->id,
                    'password' => Hash::make('password123'),
                ]);
            }

            // 2. Iniciar sesión
            Auth::login($user);

            // 3. Lógica de redirección inteligente
            $admins = ['carloseduardot109@gmail.com', 'gabyrebal23@gmail.com'];
            
            if (in_array(Auth::user()->email, $admins)) {
                // Si es administrador, va al panel de control
                return redirect()->route('admin.index');
            }

            // Si es usuario normal, va a la página principal
            return redirect('/');

        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Hubo un problema al iniciar sesión con Google.');
        }
    }
}