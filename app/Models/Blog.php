<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'blog_category_id', 'title', 'slug', 'excerpt', 'content', 'image', 'published'];

    protected $casts = [
        'published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function author() { return $this->belongsTo(User::class, 'user_id'); }
    public function blogCategory() { return $this->belongsTo(BlogCategory::class, 'blog_category_id'); }

}
