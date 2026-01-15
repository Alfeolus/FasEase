<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'organization_id',
        'user_id',
        'item_id',
        'booking_date',
        'start_time',
        'end_time',
        'status',
        'reject_reason',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
