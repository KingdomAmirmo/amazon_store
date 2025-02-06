<?php

namespace App\Models\Market;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    protected $guarded = ['id'];

    use HasFactory, SoftDeletes;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentable()
    {
        return $this->morphTo();
    }

}
