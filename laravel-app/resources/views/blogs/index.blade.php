@extends('layouts.app')

@section('content')
    <div class="pagehead">
        <h1 class="h1">Blog Listing</h1>
        <p class="muted">Search and filter without page reload (AJAX + jQuery).</p>
    </div>

    <section class="card filter">
        <form id="blog-filter" class="filter__form">
            <div class="field">
                <label class="label" for="q">Search</label>
                <input id="q" name="q" class="input" value="{{ $q }}" placeholder="Search by title/content...">
            </div>

            <div class="field">
                <label class="label" for="category">Category</label>
                <select id="category" name="category" class="input">
                    <option value="">All</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" @selected($category === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="label" for="from">From</label>
                <input id="from" name="from" type="date" class="input" value="{{ $from }}">
            </div>

            <div class="field">
                <label class="label" for="to">To</label>
                <input id="to" name="to" type="date" class="input" value="{{ $to }}">
            </div>

            <div class="filter__actions">
                <button class="btn" type="submit">Apply</button>
                <button class="btn btn--ghost" type="button" id="reset-filter">Reset</button>
            </div>
        </form>
    </section>

    <section class="results">
        <div id="results-meta" class="muted">{{ $blogs->total() }} {{ $blogs->total() === 1 ? 'blog' : 'blogs' }}</div>
        <div id="blogs-list">
            @include('blogs._list', ['blogs' => $blogs])
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/blogs.js') }}"></script>
@endpush

