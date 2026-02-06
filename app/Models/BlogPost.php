<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blog_posts';
    
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category',
        'author',
        'status',
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];
    
    protected $casts = [
        'views' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Scope for published posts
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
    
    /**
     * Check if post is published
     */
    public function getIsPublishedAttribute()
    {
        return $this->status === 'published';
    }
    
    /**
     * Get published_at as alias for created_at
     */
    public function getPublishedAtAttribute()
    {
        return $this->created_at;
    }
}
