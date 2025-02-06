<?php

namespace Modules\Post\Entities;

use App\Models\Content\Comment;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ContentCategory\Entities\PostCategory;

class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    public function sluggable(): array
    {
        return[
            'slog' => [
                'source' => 'title'
            ]
        ];
    }

    protected $casts = ['image' => 'array'];
    protected $fillable = ['title', 'summary', 'body', 'commentable', 'slog', 'image', 'status', 'tags', 'published_at', 'author_id ', 'category_id', 'author_id'];


    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
