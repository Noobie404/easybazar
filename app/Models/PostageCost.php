<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostageCost extends Model
{
    protected $table = 'SLS_POSTAGE_COST';
    protected $primaryKey   = 'PK_NO';

    protected $fillable = [
            'F_SHOP_NO','AMOUNT','FROM_PRICE', 'TO_PRICE'
    ];
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';
}
