<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    protected $guarded = ['id'];
    use HasFactory,SoftDeletes;

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function singleProduct(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function amazingSale(){
        return $this->belongsTo(AmazingSale::class,'amazing_sale_id');
    }
    public function color(){
        return $this->belongsTo(ProductColor::class,'color_id');
    }
    public function guarantee(){
        return $this->belongsTo(Guarantee::class,'guarantee_id');
    }

    public function orderItemSelectedAttributes (){
        return $this->hasMany(OrderItemSelectedAttribute::class,'order_item_id');
    }

}
