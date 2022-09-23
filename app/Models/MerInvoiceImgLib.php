<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MerInvoiceImgLib extends Model
{
    protected $table        = 'MER_PRC_IMG_LIBRARY';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;

    protected $fillable = ['F_INV_STOCK_IN_NO'];

}
