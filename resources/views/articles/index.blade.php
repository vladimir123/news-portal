@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container">
    <h1>News portal</h1>
    <p class="lead">Welcome to our news portal</p>
    <hr>

    @if($articles->count() > 0)
        <div class="row">
            @foreach($articles as $article)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ $article->excerpt }}</p>
                            <div class="text-muted small mb-2">
                                {{ $article->user->name ?? 'Author' }} | 
                                {{ $article->created_at->format('d.m.Y H:i') }} | 
                                {{ $article->comments_count ?? 0 }} comments
                            </div>
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-primary">
                                Read more ...
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- paging -->
        <div class="d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <h4>No articles</h4>
            <p>Articles will be displayed here when added</p>
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-success">
                        Add article
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>
@endsection