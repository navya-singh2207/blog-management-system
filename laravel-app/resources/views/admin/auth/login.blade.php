@extends('admin.layout')

@section('content')
    <div class="pagehead">
        <h1 class="h1">Admin Login</h1>
        <p class="muted">Simple login system for managing blogs.</p>
    </div>

    <div class="card" style="padding:16px;max-width:520px">
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="field" style="margin-bottom:12px">
                <label class="label" for="email">Email</label>
                <input id="email" class="input" name="email" type="email" value="{{ old('email') }}" required>
                @error('email')<div class="muted" style="color:var(--danger)">{{ $message }}</div>@enderror
            </div>

            <div class="field" style="margin-bottom:12px">
                <label class="label" for="password">Password</label>
                <input id="password" class="input" name="password" type="password" required>
                @error('password')<div class="muted" style="color:var(--danger)">{{ $message }}</div>@enderror
            </div>

            <button class="btn" type="submit">Login</button>

            <div class="muted" style="margin-top:10px">
                Seeded credentials: <b>admin@blog.test</b> / <b>password</b>
            </div>
        </form>
    </div>
@endsection

