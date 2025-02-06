<?php

namespace Modules\ContentCategory\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostCategory extends Model
{
    use HasFactory,SoftDeletes, Sluggable;

    public function sluggable(): array
    {
        return[
            'slog' => [
                'source' => 'name'
            ]
        ];
    }

    protected $casts = ['image' => 'array'];

    protected $fillable = ['name', 'description', 'slog', 'image', 'status', 'tags'];

}
