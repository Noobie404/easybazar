<?php

namespace App\Models;

use DB;
use App\Traits\RepoResponse;
use Illuminate\Database\Eloquent\Model;

class ApiList extends Model
{
    use RepoResponse;
    protected $table 		= 'SS_API_LIST';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;

    protected $fillable = ['NAME'];


    public function postEdit($request,$id){

        DB::beginTransaction();
        try {
            $api = ApiList::find($id);
            $api->NAME          = $request->name;
            $api->COMPANY_NAME  = $request->company_name;
            $api->WEIGHT        = $request->weight;
            $api->LENGTH        = $request->length;
            $api->WIDTH         = $request->width;
            $api->HEIGHT        = $request->height;
            $api->update();

        } catch (\Exception $e) {

            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.apilist.list');
        }

        DB::commit();
        return $this->formatResponse(true, 'API information update successfully !', 'admin.apilist.list');

    }

}
