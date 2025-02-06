<?php

namespace App\Models\Market;

use App\Models\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nagy\LaravelRating\Traits\Rateable;

class Product extends Model
{
    use HasFactory, SoftDeletes, Sluggable, Rateable;

    public function sluggable(): array
    {
        return[
            'slog' => [
                'source' => 'name'
            ]
        ];
    }
    protected $casts = ['image' => 'array'];
    protected $fillable = ['name', 'introduction', 'marketable', 'slog', 'image', 'status', 'weight', 'length',
        'height', 'width', 'price', 'tags',  'published_at', 'sold_number ', 'frozen_number', 'marketable_number',
        'category_id', 'brand_id'];


    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function metas()
    {
        return $this->hasMany(ProductMeta::class, 'product_id');
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }

    public function images()
    {
        return $this->hasMany(Gallery::class, 'product_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function amazingSales()
    {
        return $this->hasMany(AmazingSale::class);
    }

    public function activeAmazingSale()
    {
        return $this->amazingSales()->where('start_date', '<', Carbon::now())->where('end_date', '>', Carbon::now())->first();
    }

    public function guarantees()
    {
        return $this->hasMany(Guarantee::class);
    }

    public function values()
    {
        return $this->hasMany(CategoryValue::class);
    }

    public function activeComments()
    {
        return $this->comments()->orderBy('created_at')->where('approved',1)->whereNull('parent_id')->get();
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function compares()
    {
        return $this->belongsToMany(Compare::class);
    }





}
