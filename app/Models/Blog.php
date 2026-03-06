<?php

namespace App\Models;

use App\Traits\ResolvesImagePath;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory, ResolvesImagePath, \App\Traits\OptimizesImages;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'gallery_images',
        'meta_title',
        'meta_description',
        'view_count',
        'published_at',
        'is_published',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getFormattedDateAttribute(): string
    {
        if ($this->published_at) {
            return $this->published_at->translatedFormat('d F Y \p\u\k\u\l H:i');
        }

        return $this->created_at->translatedFormat('d F Y \p\u\k\u\l H:i');
    }

    public function getImageUrlAttribute(): string
    {
        return self::resolveImagePath($this->featured_image, 'images/blogs');
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery_images)) {
            return [];
        }
        return array_map(fn ($img) => self::resolveImagePath($img, 'images/blogs'), $this->gallery_images);
    }

    public function getReadTimeAttribute(): string
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return $minutes . ' ' . __('ui.min_read');
    }

    public function getShareUrlAttribute(): array
    {
        $url = route('blog.show', $this->slug);
        $text = urlencode($this->title);

        return [
            'facebook' => 'https://facebook.com/sharer.php?u='.urlencode($url),
            'twitter' => "https://twitter.com/intent/tweet?text={$text}&url=".urlencode($url),
            'whatsapp' => "https://api.whatsapp.com/send?text={$text}%0A%0A".urlencode($url),
            'telegram' => 'https://t.me/share/url?url='.urlencode($url),
        ];
    }
}
