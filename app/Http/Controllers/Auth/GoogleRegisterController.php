<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Date;
// use Laravel\Socialite\Facades\Socialite;

// class GoogleRegisterController extends Controller
// {
//     public function redirectToGoogle()
//     {
//         return Socialite::driver('google')->redirect();
//     }

//     public function handleGoogleCallback()
//     {
//         try {
//             $googleUser = Socialite::driver('google')->stateless()->user();

//             $user = User::where('email', $googleUser->getEmail())->first();

//             if (!$user) {
//                 $user = User::create([
//                     'name' => $googleUser->getName() . ' (' . trim($googleUser->getGivenName() . ' ' . ($googleUser->getFamilyName() ?? '')) . ')',
//                     'email' => $googleUser->getEmail(),
//                     'email_verified_at' => now(),
//                     'phone' => $googleUser->getPhone() ?? null,
//                     'picture' => $googleUser->getAvatar() ?? 'default_user.png',
//                     'password' => Hash::make(str()->random(24)),
//                 ]);
//             }

//             Auth::login($user);

//             return redirect()->route('book')->with('success', ['Bienvenue sur la page de réservation']);

//         } catch (\Exception $e) {
//             return redirect()->route('register')->with('error', ['Erreur lors de la connexion avec Google.']);
//         }
//     }
// }
