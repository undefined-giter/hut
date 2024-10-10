<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $user = $request->user();
        $reservations = $user->reservations()->with('options')->get();
        $connected_user_id = auth()->id();

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'reservations' => $reservations,
            'user' => $user->only(['id', 'name', 'name2', 'email', 'phone']),
            'connected_user_id' => $connected_user_id,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name2' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|size:10',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        $user->name = $request->name;
        $user->name2 = $request->name2;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->save();

        return redirect()->route('profile')->with('success', ['Profil modifié 👍']);
    }

    public function editPicture()
    {
        return Inertia::render('Profile/editPicture');
    }

    public function updatePicture(Request $request)
    {
        $request->validate([
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profiles', 'public');
            
            if ($user->picture && $user->picture !== 'default_user.png' && Storage::disk('public')->exists('profiles/' . $user->picture)) {
                Storage::disk('public')->delete('profiles/' . $user->picture);
            }
            
            $user->picture = basename($picturePath);
        } 
        elseif ($request->delete_picture) {
            if ($user->picture && $user->picture !== 'default_user.png' && Storage::disk('public')->exists('profiles/' . $user->picture)) {
                Storage::disk('public')->delete('profiles/' . $user->picture);
            }
            
            $user->picture = 'default_user.png';
        }
    
        $user->save();

        return redirect()->route('profile')->with('success', ['Photo mise à jour 👍']);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $currentUser = auth()->user();
    
        if ($currentUser->role !== 'admin') {
            if ($currentUser->id !== $user->id) {
                return redirect()->route('profile')->with('error', ['Vous n\'êtes pas autorisé à supprimer ce compte.']);
            }
    
            if (!Hash::check($request->password, $currentUser->password)) {
                return redirect()->route('profile')->with('error', ['Mot de passe incorrect.']);
            }
        }
    
        $user->delete();
    
        return redirect()->route('admin.list')->with('success', ['Le compte a été supprimé.']);
    }  
}
