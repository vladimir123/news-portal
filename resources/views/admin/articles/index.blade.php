@extends('layouts.admin')

@section('title', 'Articles settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Articles settings</h1>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-success">Add article</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tittle</th>
                <th>Author</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->user->name }}</td>
                    <td>{{ $article->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-info" target="_blank">
                            Show
                        </a>
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-sm btn-primary">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.articles.destroy', $article->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Confirm?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $articles->links() }}
@endsection