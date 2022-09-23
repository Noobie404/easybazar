<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderGroup extends Model
{
    protected $table 		= 'SLS_ORDER_GROUP';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking', 'F_BOOKING_NO');
    }
}
