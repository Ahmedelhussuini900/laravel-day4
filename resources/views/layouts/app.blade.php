<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>Laravel App</title>
    <!-- Add your CSS files here -->
</head>
<body>
    <nav>
        <div class="container">
            <!-- Navbar content -->
            <a href="{{ url('/') }}">Home</a>
            <a href="{{ url('/posts') }}">All Posts</a>
            @auth
                <a href="{{ route('posts.create') }}">Create Post</a>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                @guest
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endguest
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
