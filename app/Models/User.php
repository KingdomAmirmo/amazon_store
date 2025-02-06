<?php

namespace App\Models;

use App\Models\Market\Compare;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use App\Models\Market\Product;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketAdmin;
use App\Models\User\Permission;
use App\Models\User\Role;
use App\Models\User\RoleUser;
use App\Traits\Permissions\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Nagy\LaravelRating\Traits\CanRate;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasPermissionsTrait;
    use CanRate;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'status', 'user_type', 'activation',
        'mobile', 'profile_photo_path', 'email_verified_at', 'mobile_verified_at','national_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function ticketAdmin()
    {
        return $this->hasOne(TicketAdmin::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function roleUser()
    {
        return $this->hasOne(RoleUser::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    public function orderItems()
    {
        return $this->hasManyThrough(OrderItem::class, Order::class);
    }
    public function isUserPurchasedProduct($product_id)
    {
        //check if user logined can store point for product

        $productIds = collect();
            foreach ($this->orderItems()->where('product_id', $product_id)->get() as $item) {
                $productIds->push($item->product_id);
            }
        $productIds = $productIds->unique();
        return $productIds;
    }

    public function compare()
    {
        return $this->hasOne(Compare::class);
    }



}


