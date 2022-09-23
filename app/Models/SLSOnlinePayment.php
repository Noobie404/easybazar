<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SLSOnlinePayment extends Model
{
    protected $table 		= 'SLS_ONLINE_PAYMENTS';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;

    protected $fillable = [
        'NAME'
    ];

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking', 'F_BOOKING_NO');
    }
}
