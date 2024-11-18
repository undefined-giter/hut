<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {   
        // if ($request->hasFile('picture') && $request->file('picture')->getClientOriginalName() !== 'default_user.png') {
        //     $picturePath = $request->file('picture')->store('profiles', 'public');
        //     $picturePath = basename($picturePath);
        // } else {
            $picturePath = 'default_user.png';
        // }
        
        $request->validate([
            // 'name' => 'required|string|min:2|max:255',
            // 'name2' => 'nullable|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'phone' => ['nullable', 'string', 'size:10'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'picture' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = User::create([
            // 'name' => $request->name,
            // 'name2' => $request->name2,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'picture' => $picturePath,
        ]);

        $user->sendEmailVerificationNotification();

        Auth::login($user);

        return redirect()->route('gallery')->with('success', ['Veuillez vérifier vos mails pour confirmer votre inscription svp.']);
    }
}
