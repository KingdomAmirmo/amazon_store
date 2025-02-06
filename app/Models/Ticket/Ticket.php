<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subject', 'description', 'reference_id', 'seen', 'category_id', 'priority_id',
        'status', 'ticket_id','user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(TicketAdmin::class, 'reference_id');
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class);
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class);
    }



    // برای جوین داخلی با خود جدول
    public function parent()
    {
        return $this->belongsTo($this, 'ticket_id')->with('parent');
    }
    public function children()
    {
        return $this->hasMany($this, 'ticket_id')->with('children');
    }

    public function file()
    {
        return $this->hasOne(TicketFile::class);
    }


}
