<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferGroup extends Model
{
    protected $table 		= 'SLS_BUNDLE_GROUP';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;

    protected $fillable = [
        'BUNDLE_NAME'
    ];


    public function allOffers() {
        return $this->hasMany('App\Models\Offer', 'F_BUNDLE_GROUP_NO');
    }


}
