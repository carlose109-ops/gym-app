<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name'      => $googleUser->name,
                    'email'     => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password'  => Hash::make('password123'),
                ]);
            } else {
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->id;
                    $user->save();
                }
            }

            Auth::login($user);

            $admins = ['carloseduardot109@gmail.com', 'gabyrebal23@gmail.com'];

            if (in_array($user->email, $admins)) {
                return redirect()->route('admin.index')->with('success', 'Bienvenido al panel de administración.');
            }

            return redirect('/')->with('success', 'Has iniciado sesión correctamente.');

        } catch (Exception $e) {
            Log::error('Error en login con Google: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Hubo un problema al iniciar sesión con Google. Inténtalo de nuevo.');
        }
    }
}