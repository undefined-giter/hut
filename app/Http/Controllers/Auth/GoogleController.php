<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email', 'https://www.googleapis.com/auth/user.phonenumbers.read'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $phone = $googleUser->user['phoneNumbers'][0]['value'] ?? null;

            // Vérifie si l'utilisateur existe déjà dans la base de données
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                // Si l'utilisateur existe mais n'a pas de google_id, on l'ajoute
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }

                // Marque l'email comme vérifié si ce n'est pas déjà fait
                if (is_null($user->email_verified_at)) {
                    $user->update(['email_verified_at' => now()]);
                }

                // Connecte l'utilisateur existant
                Auth::login($user);
            } else {
                // Si l'utilisateur n'existe pas, on le crée
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'phone' => $phone,
                    'picture' => $googleUser->getAvatar() ?? 'default_user.png',
                    'password' => Hash::make(str()->random(24)),
                ]);

                // Connecte le nouvel utilisateur
                Auth::login($user);
            }

            return redirect()->route('book')->with('success', ['Vous pouvez à présent réserver votre bonheur']);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', ['Erreur lors de la connexion avec Google.']);
        }
    }

    // Méthode de connexion classique
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            // Si l'utilisateur a été inscrit via Google, affichage d'un message spécifique
            if ($user->google_id) {
                return redirect()->route('login')->withErrors([
                    'email' => ['Vous avez créé ce compte avec Google. Veuillez vous connecter avec Google.'],
                ]);
            }

            // Tentative de connexion classique
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/book')->with('success', ['Vous pouvez à présent réserver votre bonheur']);
            }
        }

        return back()->withErrors([
            'email' => ['Les informations de connexion ne sont pas correctes.'],
        ]);
    }
}
