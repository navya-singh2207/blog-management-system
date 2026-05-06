@php
    use Illuminate\Support\Facades\Storage;
@endphp

@if($blogs->count() === 0)
    <div class="card empty">
        <h2 class="h2">No blogs found</h2>
        <p class="muted">Try changing your filters.</p>
    </div>
@else
    <div class="grid">
        @foreach($blogs as $blog)
            <article class="card blogcard">
                <a class="blogcard__media" href="{{ route('blogs.show', $blog) }}">
                    @if($blog->image_path)
                        <img src="{{ Storage::url($blog->image_path) }}" alt="{{ $blog->title }}">
                    @else
                        <div class="blogcard__placeholder">No image</div>
                    @endif
                </a>
                <div class="blogcard__body">
                    <div class="blogcard__meta">
                        <span class="pill">{{ $blog->category }}</span>
                        <span class="muted">{{ optional($blog->published_at)->format('d M Y') }}</span>
                    </div>
                    <h2 class="h2 blogcard__title">
                        <a href="{{ route('blogs.show', $blog) }}">{{ $blog->title }}</a>
                    </h2>
                    <p class="blogcard__excerpt">{{ $blog->excerpt }}</p>
                    <a class="link" href="{{ route('blogs.show', $blog) }}">Read more</a>
                </div>
            </article>
        @endforeach
    </div>

    <div class="pagination">
        {{ $blogs->links() }}
    </div>
@endif

