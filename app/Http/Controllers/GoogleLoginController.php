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

            // 1. Buscar al usuario por email
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Si el usuario ya existe, iniciar sesión
                Auth::login($user);
            } else {
                // 2. Si no existe, crearlo
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make('password123'), // O cualquier password temporal
                ]);

                Auth::login($newUser);
            }

            // 3. Redirigir al home o dashboard
            return redirect('/home');

        } catch (Exception $e) {
            // Si hay error, redirigir al login con mensaje
            return redirect('/login')->with('error', 'Hubo un problema al iniciar sesión con Google: ' . $e->getMessage());
        }
    }
}