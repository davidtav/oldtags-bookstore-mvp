<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Erro ao autenticar com Google.');
        }

        // Verifica se o usuário já existe
        $user = User::where('email', $googleUser->email)->first();

        // Se não existir, cria
        if (!$user) {
            $user = User::create([
                'name'  => $googleUser->name,
                'email' => $googleUser->email,
                'password' => bcrypt(uniqid()), // senha aleatória e segura
            ]);
        }

        // Faz o login
        Auth::login($user, true);

        // Redireciona para o Filament
        return redirect('/admin');
    }
}
