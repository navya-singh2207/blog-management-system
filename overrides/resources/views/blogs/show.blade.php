@extends('layouts.app')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="crumbs">
        <a class="link" href="{{ route('blogs.index') }}">← Back to blogs</a>
    </div>

    <article class="card blogdetail">
        <div class="blogdetail__head">
            <div class="blogdetail__meta">
                <span class="pill">{{ $blog->category }}</span>
                <span class="muted">{{ optional($blog->published_at)->format('d M Y') }}</span>
            </div>
            <h1 class="h1">{{ $blog->title }}</h1>
        </div>

        @if($blog->image_path)
            <div class="blogdetail__image">
                <img src="{{ Storage::url($blog->image_path) }}" alt="{{ $blog->title }}">
            </div>
        @endif

        <div class="prose">
            {!! $blog->content !!}
        </div>
    </article>
@endsection

