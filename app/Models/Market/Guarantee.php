<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guarantee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'price_increase', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
