<?php

namespace App\Models\Market;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlinePayment extends Model
{
    protected $guarded = ['id'];

    use HasFactory,SoftDeletes;


    public function payments()
    {
        return $this->morphMany(Payment::class, 'paymentable');
    }

}
