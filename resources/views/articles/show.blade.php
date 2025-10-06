@extends('layouts.app')

@section('title', $article->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <article class="mb-4">
            <h1>{{ $article->title }}</h1>
            <p class="text-muted">
                Author: {{ $article->user->name }} | 
                {{ $article->created_at->format('d.m.Y H:i') }}
            </p>
            <div class="content">
                {!! nl2br(e($article->content)) !!}
            </div>
        </article>

        <section class="comments">
            <h3>Комментарии ({{ $article->approvedComments->count() }})</h3>

            <!-- comment form -->
            <div class="card mb-4">
                <div class="card-header">Add comment</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('comments.store', $article->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="author_name" class="form-label">Name *</label>
                            <input type="text" class="form-control @error('author_name') is-invalid @enderror" 
                                   id="author_name" name="author_name" value="{{ old('author_name') }}" required>
                            @error('author_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="author_email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('author_email') is-invalid @enderror" 
                                   id="author_email" name="author_email" value="{{ old('author_email') }}" required>
                            @error('author_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Comment *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- CAPTCHA -->
                        <div class="mb-3">
                            <label class="form-label">Answer question 2 + 2? *</label>
                            <input type="number" class="form-control @error('captcha') is-invalid @enderror" 
                                   name="captcha_answer" required>
                            @error('captcha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

            <!-- comments -->
            @forelse($article->approvedComments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">{{ $comment->author_name }}</h6>
                        <p class="card-text">{!! nl2br(e($comment->content)) !!}</p>
                        <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                    </div>
                </div>
            @empty
                <p>No comments</p>
            @endforelse
        </section>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Latest articles</div>
            <div class="card-body">
                <p>Latest articles</p>
            </div>
        </div>
    </div>
</div>
@endsection