<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCommentRequest;
use App\Models\Admin\AdminComment;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;


class AdminCommentController extends Controller
{
    public function index($userId): Response
    {
        $comments = AdminComment::where('user_id', $userId)->get();

        return Inertia::render('Admin/Comments', [
            'comments' => $comments,
            'user_id' => $userId,
        ]);
    }

    public function store(AdminCommentRequest $request): RedirectResponse
    {
        $user = Auth::user();
    
        if ($user->role === 'fake_admin') {
            return redirect()->back()->with('error', ['Vous n\'êtes pas autorisé à ajouter de commentaire, en tant que fake_admin.']);
        }

        AdminComment::create([
            'user_id' => $request->user_id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', ['Commentaire ajouté']);
    }

    public function update(AdminCommentRequest $request, $commentId): RedirectResponse
    {
        $user = Auth::user();
    
        if ($user->role === 'fake_admin') {
            return redirect()->back()->with('error', ['Vous n\'êtes pas autorisé à modifier de commentaire, en tant que fake_admin.']);
        }

        $comment = AdminComment::findOrFail($commentId);
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', ['Commentaire mis à jour']);
    }

    public function destroy($commentId): RedirectResponse
    {
        $user = Auth::user();
    
        if ($user->role === 'fake_admin') {
            return redirect()->back()->with('error', ['Vous n\'êtes pas autorisé à supprimer de commentaire, en tant que fake_admin.']);
        }

        $comment = AdminComment::findOrFail($commentId);
        $comment->delete();

        return redirect()->back()->with('success', ['Commentaire supprimé.']);
    }
}
