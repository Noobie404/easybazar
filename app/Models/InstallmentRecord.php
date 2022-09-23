<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentRecord extends Model
{
    protected $table 		= 'ACC_INSTALLMENT_RECORD';
    protected $primaryKey   = 'PK_NO';

    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

}
