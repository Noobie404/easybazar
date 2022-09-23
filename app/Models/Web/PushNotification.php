<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{


    protected $table        = 'WEB_NOTIFICATION';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;
    const CREATED_AT        = 'CREATED_ON';
    const MODIFIED_ON       = 'MODIFIED_ON';

}
