<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;


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
