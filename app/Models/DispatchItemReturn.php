<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispatchItemReturn extends Model
{
    protected $table 		= 'SC_ORDER_ITEM_RETURN';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;


    public function booking_details()
    {
        return $this->belongsTo('App\Models\BookingDetails', 'F_BOOKING_DETAILS_NO');
    }

    public function booking() {
        return $this->belongsTo('App\Models\Booking', 'F_BOOKING_NO', 'PK_NO');
    }

    public function requestBy() {
        return $this->belongsTo('App\Models\Auth', 'F_REQUEST_BY', 'PK_NO');
    }



}
