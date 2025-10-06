@extends('layouts.admin')

@section('title', 'Comment noderation')

@section('content')
<h1>Comment noderation</h1>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Author</th>
                <th>Article</th>
                <th>Comment</th>
                <th>Statuss</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
                <tr class="{{ !$comment->approved ? 'table-warning' : '' }}">
                    <td>{{ $comment->id }}</td>
                    <td>
                        {{ $comment->author_name }}<br>
                        <small class="text-muted">{{ $comment->author_email }}</small>
                    </td>
                    <td>
                        <a href="{{ route('articles.show', $comment->article->id) }}" target="_blank">
                            {{ Str::limit($comment->article->title, 30) }}
                        </a>
                    </td>
                    <td>{{ Str::limit($comment->content, 100) }}</td>
                    <td>
                        @if($comment->approved)
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-warning">In progress</span>
                        @endif
                    </td>
                    <td>{{ $comment->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        @if(!$comment->approved)
                            <form method="POST" action="{{ route('admin.comments.approve', $comment->id) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.comments.destroy', $comment->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Confirm?')">
                                Remove
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $comments->links() }}
@endsection