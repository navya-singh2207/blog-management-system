<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Blog Management System' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header class="topbar">
        <div class="container topbar__inner">
            <a class="brand" href="{{ route('blogs.index') }}">Blogs</a>
            <nav class="nav">
                <a class="nav__link" href="{{ route('blogs.index') }}">All blogs</a>
                <a class="nav__link" href="{{ route('admin.login') }}">Admin</a>
            </nav>
        </div>
    </header>

    <main class="container content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container footer__inner">
            <span>Blog Management System</span>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
</body>
</html>

