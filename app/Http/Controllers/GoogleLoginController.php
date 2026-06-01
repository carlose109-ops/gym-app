<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;

class GoogleLoginController extends Controller
{
    /**
     * Redirecciona al usuario a la página de autenticación de Google.
     */
    public function redirectToGoogle()
    {
        // Al no pasarle nada a Socialite, este toma automáticamente 
        // el 'redirect' definido en config/services.php
        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja la respuesta del callback de Google.
     */
    public function handleGoogleCallback()
    {
        try {
            // Al igual que arriba, aquí también dejamos que Socialite 
            // valide la respuesta usando la configuración centralizada.
            $googleUser = Socialite::driver('google')->user();
                
            // Aquí va tu lógica para buscar o crear el usuario en la base de datos...
            // $user = User::where('email', $googleUser->email)->first();
            // ...
            
        } catch (Exception $e) {
            // Es muy útil imprimir el error si esto sigue fallando
            // dd($e->getMessage()); 
            return redirect('/login')->with('error', 'Hubo un problema al iniciar sesión con Google.');
        }
    }
}