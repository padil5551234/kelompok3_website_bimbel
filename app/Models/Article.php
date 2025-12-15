<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'author_id',
        'status',
        'is_featured',
        'views_count',
        'tags',
        'meta_keywords',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'tags' => 'array',
        'meta_keywords' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $baseSlug = Str::slug($article->title);
                $slug = $baseSlug;
                $counter = 1;
                
                // Check if slug already exists, add counter if needed
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                $article->slug = $slug;
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title')) {
                $baseSlug = Str::slug($article->title);
                $slug = $baseSlug;
                $counter = 1;
                
                // Check if slug already exists (excluding current article), add counter if needed
                while (static::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                $article->slug = $slug;
            }
        });
    }

    /**
     * Get the author of the article
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Scope published articles
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope featured articles
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Increment views
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Get excerpt or generate from content
     */
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return Str::limit(strip_tags($this->content), 200);
    }

    /**
     * Get reading time in minutes
     */
    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        
        return $readingTime;
    }

    /**
     * Check if article is published
     */
    public function isPublished()
    {
        return $this->status === 'published' 
            && $this->published_at !== null 
            && $this->published_at <= now();
    }

    /**
     * Get formatted published date
     */
    public function getFormattedPublishedDateAttribute()
    {
        if (!$this->published_at) {
            return null;
        }

        return $this->published_at->format('d M Y');
    }

    /**
     * Get category badge color
     */
    public function getCategoryBadgeColorAttribute()
    {
        $colors = [
            'tips' => 'primary',
            'strategi' => 'success',
            'pengumuman' => 'warning',
            'umum' => 'secondary',
            'motivasi' => 'info',
        ];

        return $colors[$this->category] ?? 'secondary';
    }
}