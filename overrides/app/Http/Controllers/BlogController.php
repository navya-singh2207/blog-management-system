<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', ''));
        $from = $request->query('from');
        $to = $request->query('to');

        $query = Blog::query()->orderByDesc('published_at')->orderByDesc('id');

        if ($q !== '') {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            });
        }

        if ($category !== '') {
            $query->where('category', $category);
        }

        if ($from) {
            $fromDate = Carbon::parse($from)->startOfDay();
            $query->where('published_at', '>=', $fromDate);
        }
        if ($to) {
            $toDate = Carbon::parse($to)->endOfDay();
            $query->where('published_at', '<=', $toDate);
        }

        $blogs = $query->paginate(6)->withQueryString();

        $categories = Blog::query()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->all();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('blogs._list', compact('blogs'))->render(),
                'count' => $blogs->total(),
            ]);
        }

        return view('blogs.index', compact('blogs', 'categories', 'q', 'category', 'from', 'to'));
    }

    public function show(Blog $blog)
    {
        return view('blogs.show', compact('blog'));
    }
}

