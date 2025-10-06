<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    //add comment
    public function store(Request $request, $articleId)
    {
        $article = Article::findOrFail($articleId);

        //CAPTCHA
        if ($request->input('captcha_answer') != '4') {
            return back()
                ->withErrors(['captcha' => 'Incorrect answer'])
                ->withInput();
        }

        $validated = $request->validate([
            'content' => 'required|max:1000',
            'author_name' => 'required|max:255',
            'author_email' => 'required|email|max:255'
        ]);

        $validated['article_id'] = $articleId;
        $validated['approved'] = false;

        Comment::create($validated);

        return back()->with('success', 'Comment sended for moderation');
    }

    //comments list in admin
    public function adminIndex()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }

        $comments = Comment::with('article')
            ->latest()
            ->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    public function approve($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }

        $comment = Comment::findOrFail($id);
        $comment->update(['approved' => true]);

        return back()->with('success', 'Comment approved!');
    }

    public function destroy($id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }

        $comment = Comment::findOrFail($id);
        $comment->delete();

        return back()->with('success', 'Comment removed!');
    }
}
