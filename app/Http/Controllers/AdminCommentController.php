<?php

namespace App\Http\Controllers;

use App\Models\AdminComment;
use App\Http\Requests\AdminCommentRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

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
        AdminComment::create([
            'user_id' => $request->user_id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', ['Commentaire ajouté']);
    }

    public function update(AdminCommentRequest $request, $commentId): RedirectResponse
    {
        $comment = AdminComment::findOrFail($commentId);
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', ['Commentaire mis à jour']);
    }

    public function destroy($commentId): RedirectResponse
    {
        $comment = AdminComment::findOrFail($commentId);
        $comment->delete();

        return redirect()->back()->with('success', ['Commentaire supprimé.']);
    }
}
