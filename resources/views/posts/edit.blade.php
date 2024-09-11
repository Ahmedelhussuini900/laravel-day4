@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}" required>

        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="content">Content:</label>
        <textarea name="content" id="content" required>{{ old('content', $post->content) }}</textarea>

        @error('content')
            <div class="error">{{ $message }}</div>
        @enderror

        <!-- <label for="image">Image (optional):</label>
        <input type="file" name="image" id="image"> -->

        @error('image')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Update Post</button>
    </form> 
@endsection
