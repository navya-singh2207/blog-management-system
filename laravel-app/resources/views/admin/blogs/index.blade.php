@extends('admin.layout')

@section('content')
    <div class="adminbar card">
        <div>
            <h1 class="h1" style="margin:0">Manage Blogs</h1>
            <div class="muted">Add, edit, delete blog posts.</div>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <a class="btn" href="{{ route('admin.blogs.create') }}">+ Add blog</a>
        </div>
    </div>

    <div class="card tablewrap">
        <table>
            <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Date</th>
                <th style="width:220px">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($blogs as $blog)
                <tr>
                    <td>
                        <div style="font-weight:800">{{ $blog->title }}</div>
                        <div class="muted" style="font-size:12px">{{ $blog->slug }}</div>
                    </td>
                    <td><span class="pill">{{ $blog->category }}</span></td>
                    <td class="muted">{{ optional($blog->published_at)->format('d M Y') }}</td>
                    <td>
                        <div class="row-actions">
                            <a class="btn btn--ghost" href="{{ route('blogs.show', $blog) }}">View</a>
                            <a class="btn btn--ghost" href="{{ route('admin.blogs.edit', $blog) }}">Edit</a>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Delete this blog?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn--danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="muted">No blogs yet. Create your first one.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $blogs->links() }}
    </div>
@endsection

