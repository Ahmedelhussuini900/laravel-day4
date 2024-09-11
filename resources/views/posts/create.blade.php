@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <h1>Create Post</h1>

    <!-- Display error messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="{{ old('title') }}" required>
        @error('title')
            <div class="error">{{ $message }}</div>
        @enderror
        
        <label for="content">Content:</label>
        <textarea name="content" id="content" required>{{ old('content') }}</textarea>
        @error('content')
            <div class="error">{{ $message }}</div>
        @enderror

        <!-- <label for="image">Image:</label>
        <input type="file" name="image" id="image"> -->
        
        <button type="submit">Save Post</button>
    </form> 
@endsection
