<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerStockGeneration extends Model
{
    protected $table = 'MER_is_manual';

    protected $primaryKey 	= 'PK_NO';
    protected $fillable 	= ['PK_NO','F_PRC_STOCK_IN_NO','F_INV_WAREHOUSE_NO'];
    public $timestamps 		= false;

	// const CREATED_AT = 'create_dttm';
	// const UPDATED_AT = 'update_dttm';
}
