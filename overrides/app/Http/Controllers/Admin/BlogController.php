<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::query()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $blog = new Blog([
            'published_at' => now(),
        ]);

        return view('admin.blogs.form', [
            'blog' => $blog,
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $blog = new Blog($data);

        if ($request->hasFile('image')) {
            $blog->image_path = $request->file('image')->store('blogs', 'public');
        }

        $blog->ensureSlugAndExcerpt();
        $blog->save();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created.');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.form', [
            'blog' => $blog,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $this->validated($request, $blog->id);

        $blog->fill($data);

        if ($request->hasFile('image')) {
            if ($blog->image_path) {
                Storage::disk('public')->delete($blog->image_path);
            }
            $blog->image_path = $request->file('image')->store('blogs', 'public');
        }

        if (!$blog->slug || Str::slug($blog->title) !== $blog->slug) {
            $blog->slug = null;
        }

        $blog->ensureSlugAndExcerpt();
        $blog->save();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => ['required', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string', 'max:255'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];

        $data = $request->validate($rules);

        // Normalize category spacing
        $data['category'] = trim(preg_replace('/\s+/', ' ', $data['category']));

        return $data;
    }
}

