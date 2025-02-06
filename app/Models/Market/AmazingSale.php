<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AmazingSale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'start_date', 'end_date', 'percentage', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
