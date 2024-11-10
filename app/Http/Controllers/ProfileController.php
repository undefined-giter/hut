<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfilePictureRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;

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
            'user' => $user->only(['id', 'name', 'name2', 'email', 'phone', 'google_id']),
            'connected_user_id' => $connected_user_id,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->name = $request->name ?: null;
        $user->name2 = $request->name2 ?: null;
        $user->email = $request->email;
        $user->phone = $request->phone ?: null;

        $user->save();

        return redirect()->route('profile')->with('success', ['Profil modifié 👍']);
    }

    public function editPicture(): Response
    {
        return Inertia::render('Profile/editPicture');
    }

    public function updatePicture(UpdateProfilePictureRequest $request): RedirectResponse
    {
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


    public function fetchPhone(Request $request)
    {
        return response()->json(['phone' => Auth::user()->phone]);
    }

    public function updatePhone(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|regex:/^0[1-9][0-9]{8}$/',
        ]);
    
        $user = Auth::user();
        $user->phone = $request->phone;
        $user->save();
    
        return response()->json(['message' => ['Numéro de téléphone mis à jour avec succès']]);
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $currentUser = auth()->user();

        $userEmail = $user->email;
        
        if ($currentUser->role === 'fake_admin'){
            return redirect()->route('profile')->with('error', ['En tant que fake_admin, vous n\'êtes autorisé à supprimer aucun compte, y compris {$userEmail}.']); 
        }

        $user = User::findOrFail($id);

        if ($currentUser->role !== 'admin') {
            if ($currentUser->id !== $user->id) {
                return redirect()->route('profile')->with('error', ['Vous n\'êtes pas autorisé à supprimer ce compte.']);
            }

            if ($currentUser->google_id && $currentUser->id === $user->id) {
                $user->delete();
                Auth::logout();
            
                return redirect()->route('homepage', ['account_deleted' => 'true']);
            }

            if (!Hash::check($request->password, $currentUser->password)) {
                return redirect()->route('profile')->with('error', ['Mot de passe incorrect.']);
            }else{
                $user->delete();
                Auth::logout();
                return redirect()->route('homepage', ['account_deleted' => 'true']);
            }
        }

        $user->delete();
        return redirect()->route('admin.list')->with('success', ['Le compte de l\'utilisateur {$userEmail} a bien été supprimé.']);
    }
}
