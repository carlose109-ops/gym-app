<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GoogleLoginController extends Controller
{
    public function redirectToGoogle()
    {
        // Forzamos la URL de redirección directamente en la petición
        return Socialite::driver('google')
            ->redirectUrl('http://127.0.0.1:8000/google-callback')
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // También forzamos la URL aquí para que Google nos deje entrar
            $googleUser = Socialite::driver('google')
                ->redirectUrl('http://127.0.0.1:8000/google-callback')
                ->user();

            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(uniqid()) 
                ]
            );

            Auth::login($user);
            return redirect('/');

        } catch (\Exception $e) {
            // Esto detendrá la página y te mostrará el error exacto
            dd($e->getMessage()); 
        }
    }
}