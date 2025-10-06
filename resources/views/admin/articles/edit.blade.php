@extends('layouts.admin')

@section('title', 'Edit')

@section('content')
<h1>Edit</h1>

<form method="POST" action="{{ route('admin.articles.update', $article->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="title" class="form-label">Tittle *</label>
        <input type="text" class="form-control @error('title') is-invalid @enderror" 
               id="title" name="title" value="{{ old('title', $article->title) }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="excerpt" class="form-label">Description *</label>
        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                  id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt', $article->excerpt) }}</textarea>
        @error('excerpt')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content *</label>
        <textarea class="form-control @error('content') is-invalid @enderror" 
                  id="content" name="content" rows="10" required>{{ old('content', $article->content) }}</textarea>
        @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>
@endsection