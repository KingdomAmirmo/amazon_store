<?php

namespace App\Models\Market;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
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

    protected $fillable = ['name', 'description', 'slog', 'image', 'status', 'tags', 'show_in_menu', 'parent_id'];


    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // برای جوین داخلی با خود جدول
    public function parent()
    {
        return $this->belongsTo($this, 'parent_id')->with('parent');
    }
    public function children()
    {
        return $this->hasMany($this, 'parent_id')->with('children');
    }

    public function attributes()
    {
        return $this->hasMany(CategoryAttribute::class, 'category_id');
    }

}
