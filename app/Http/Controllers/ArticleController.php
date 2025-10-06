<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['user', 'comments' => function($query) {
            $query->where('approved', true);
        }])
        ->latest()
        ->paginate(10);

        //comment count for each article
        $articles->getCollection()->transform(function ($article) {
            $article->comments_count = $article->comments->count();
            return $article;
        });

        return view('articles.index', compact('articles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::with(['user', 'approvedComments']) ->findOrFail($id);

        return view('articles.show', compact('article'));
    }

    //article list for admin
    public function adminIndex()
    {
        //admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }

        $articles = Article::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }

        return view('admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'required|max:500'
        ]);

        $validated['user_id'] = Auth::id();

        Article::create($validated);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article saved successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }

        $article = Article::findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }

        $article = Article::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'required|max:500'
        ]);

        $article->update($validated);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/login')->with('error', 'Access denied');
        }

        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article deleted successfully!');
    }
}
