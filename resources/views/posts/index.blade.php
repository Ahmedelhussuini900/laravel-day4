@extends('layouts.app')

@section('content')
<div>
    <h1>Posts</h1>
    <a href="{{ route('posts.create') }}">Create New Post</a>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Slug</th> <!-- Add this line -->
                <th>Posted By</th>
                <th>Created At</th>
                <!-- <th>Image</th> -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($post->content, 50) }}</td> <!-- Limit content to 50 characters -->
                    <td>{{ $post->slug }}</td> <!-- Add this line to show slug -->
                    <td>{{ $post->user ? $post->user->name : 'No User' }}</td>
                    <td>{{ $post->created_at->format('Y-m-d H:i') }}</td> <!-- Format the created date -->
                    <!-- <td>
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" style="max-width: 100px; max-height: 100px;">
                        @else
                            No Image
                        @endif
                    </td> -->
                    <td>
                        @if ($post->deleted_at)
                            <a href="{{ route('posts.restore', $post->id) }}" onclick="return confirm('Are you sure you want to restore this post?');">Restore</a>
                        @else
                            <a href="{{ route('posts.show', $post->id) }}">View</a>
                            <a href="{{ route('posts.edit', $post->id) }}">Edit</a>
                            <a href="{{ route('posts.confirmDelete', $post->id) }}" class="btn btn-danger">Delete</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $posts->links() }} <!-- Pagination links -->
</div>
@endsection
