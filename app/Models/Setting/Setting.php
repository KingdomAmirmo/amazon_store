<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'settings';


    //'logo' => 'array'
    protected $casts = ['image' => 'array', 'icon' => 'array'];
    protected $fillable = ['title', 'description','logo'. 'icon', 'keywords'];
}
