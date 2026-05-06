@extends('admin.layout')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
    <div class="pagehead">
        <h1 class="h1">{{ $mode === 'create' ? 'Add Blog' : 'Edit Blog' }}</h1>
        <p class="muted">Fields: Title, Content, Category, Image (optional), Date, Excerpt.</p>
    </div>

    <div class="card" style="padding:16px">
        <form method="POST"
              action="{{ $mode === 'create' ? route('admin.blogs.store') : route('admin.blogs.update', $blog) }}"
              enctype="multipart/form-data">
            @csrf
            @if($mode === 'edit')
                @method('PUT')
            @endif

            <div class="field" style="margin-bottom:12px">
                <label class="label" for="title">Title</label>
                <input id="title" class="input" name="title" value="{{ old('title', $blog->title) }}" required>
                @error('title')<div class="muted" style="color:var(--danger)">{{ $message }}</div>@enderror
            </div>

            <div class="field" style="margin-bottom:12px">
                <label class="label" for="category">Category</label>
                <input id="category" class="input" name="category" value="{{ old('category', $blog->category) }}" placeholder="Admit Card / Result / Notice" required>
                @error('category')<div class="muted" style="color:var(--danger)">{{ $message }}</div>@enderror
            </div>

            <div class="field" style="margin-bottom:12px">
                <label class="label" for="published_at">Date</label>
                <input id="published_at" class="input" type="date" name="published_at" value="{{ old('published_at', optional($blog->published_at)->format('Y-m-d')) }}">
                @error('published_at')<div class="muted" style="color:var(--danger)">{{ $message }}</div>@enderror
            </div>

            <div class="field" style="margin-bottom:12px">
                <label class="label" for="excerpt">Short description (optional)</label>
                <input id="excerpt" class="input" name="excerpt" value="{{ old('excerpt', $blog->excerpt) }}" placeholder="If empty, we auto-generate from content">
                @error('excerpt')<div class="muted" style="color:var(--danger)">{{ $message }}</div>@enderror
            </div>

            <div class="field" style="margin-bottom:12px">
                <label class="label" for="content">Content (HTML allowed)</label>
                <textarea id="content" class="input" name="content" rows="10" required>{{ old('content', $blog->content) }}</textarea>
                @error('content')<div class="muted" style="color:var(--danger)">{{ $message }}</div>@enderror
            </div>

            <div class="field" style="margin-bottom:12px">
                <label class="label" for="image">Image (optional)</label>
                <input id="image" class="input" type="file" name="image" accept="image/*">
                @error('image')<div class="muted" style="color:var(--danger)">{{ $message }}</div>@enderror

                @if($mode === 'edit' && $blog->image_path)
                    <div class="muted" style="margin-top:10px">Current image:</div>
                    <div style="margin-top:8px;max-width:420px;border-radius:14px;overflow:hidden;border:1px solid var(--border)">
                        <img src="{{ Storage::url($blog->image_path) }}" alt="{{ $blog->title }}" style="width:100%;display:block">
                    </div>
                @endif
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <button class="btn" type="submit">{{ $mode === 'create' ? 'Create' : 'Save changes' }}</button>
                <a class="btn btn--ghost" href="{{ route('admin.blogs.index') }}">Cancel</a>
            </div>
        </form>
    </div>
@endsection

