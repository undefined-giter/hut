<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;


class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes([
                'openid',
                'profile',
                'email',
                'https://www.googleapis.com/auth/user.phonenumbers.read'
            ])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $phone = $googleUser->user['phoneNumbers'][0]['value'] ?? $googleUser->user['phone_number'] ?? null;

            if (!$phone) {
                $client = new Client();
                $response = $client->get('https://people.googleapis.com/v1/people/me', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $googleUser->token,
                    ],
                    'query' => [
                        'personFields' => 'phoneNumbers',
                    ],
                ]);
                
                $person = json_decode($response->getBody(), true);
                $phone = $person['phoneNumbers'][0]['value'] ?? null;
            }
            
            if($phone){ $phone = preg_replace('/^(\+33|33)/', '0', $phone); }

            // Vérifie si l'utilisateur existe déjà dans la base de données
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                $user->update([
                    'google_id' => $user->google_id ?? $googleUser->getId(),
                    'email_verified_at' => $user->email_verified_at ?? now(),
                    'last_login' => now(),
                ]);
                $userIsNew = false;
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                    'phone' => $phone,
                    'picture' => $googleUser->getAvatar() ?? 'default_user.png',
                    'password' => Hash::make(str()->random(24)),
                    //'last_login' => now(),
                ]);
                $userIsNew = true;
            }
            
            Auth::login($user);

            $redirect = redirect()->route('book')->with('success', ['Vous pouvez à présent réserver votre séjour de bonheur']);
            if ($userIsNew) { $redirect->with('showAccountRoad', true); }
            return $redirect;
            
        } catch (\Exception $e) {
            \Log::error('Erreur de connexion avec Google : '.$e->getMessage());
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
