<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'content',
        'seo_title', 'seo_description', 'seo_keywords'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

