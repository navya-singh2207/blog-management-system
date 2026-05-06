<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin - Blog Management' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <header class="topbar">
        <div class="container topbar__inner">
            <a class="brand" href="{{ route('admin.blogs.index') }}">Admin</a>
            <nav class="nav">
                <a class="nav__link" href="{{ route('blogs.index') }}">User site</a>
                @if(isset($currentAdmin))
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button class="btn btn--ghost" type="submit">Logout</button>
                    </form>
                @endif
            </nav>
        </div>
    </header>

    <main class="container content">
        @if(session('success'))
            <div class="alert alert--ok">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert--err">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>

