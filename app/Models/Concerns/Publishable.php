<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait Publishable
{
    public static function bootPublishable(): void
    {
        static::saving(function ($model) {
            if (blank($model->slug) || $model->isDirty('title')) {
                $base = Str::slug(Str::limit($model->title, 80, '')) ?: 'konten';
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->whereKeyNot($model->getKey())->exists()) {
                    $slug = $base.'-'.$i++;
                }
                $model->slug = $slug;
            }
            if ($model->is_published && blank($model->published_at)) {
                $model->published_at = now();
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now())
            ->latest('published_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
