<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'image_path',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => trim($value),
        );
    }

    public function ensureSlugAndExcerpt(): void
    {
        if (!$this->slug) {
            $base = Str::slug($this->title);
            $slug = $base;
            $i = 2;
            while (static::query()->where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
                $slug = "{$base}-{$i}";
                $i++;
            }
            $this->slug = $slug;
        }

        if (!$this->excerpt) {
            $this->excerpt = Str::limit(trim(strip_tags($this->content ?? '')), 160);
        }
    }
}

