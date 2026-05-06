<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $seed = [
            [
                'title' => 'UPSC Result 2026: Highlights',
                'category' => 'Result',
                'content' => '<p>This is a sample blog post to demonstrate listing, detail view, and filtering.</p><p>Replace this with real content from the admin panel.</p>',
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Railway Admit Card Released',
                'category' => 'Admit Card',
                'content' => '<p>Sample admit card update content. Use the admin panel to manage posts.</p>',
                'published_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Exam Schedule Update',
                'category' => 'Notice',
                'content' => '<p>Sample notice content with more details.</p>',
                'published_at' => Carbon::now()->subDays(20),
            ],
        ];

        foreach ($seed as $item) {
            $blog = new Blog($item);
            $blog->ensureSlugAndExcerpt();
            $blog->save();
        }
    }
}

