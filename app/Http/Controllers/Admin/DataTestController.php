<?php
namespace App\Http\Controllers\Admin;
use App\Traits\MAIL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DataTestController extends Controller
{
    use MAIL;
    protected $user;
    protected $auth;

    public function dataTest(Request $request)
    {
        DB::beginTransaction();
        try{
          } catch (\Exception $e) {
            DB::rollback();
            return 'asdasdasd  '.$e->getMessage();
        }
        // DB::commit();
        return 1;
        // ALTER TABLE SS_PO_CODE AUTO_INCREMENT = 1;
    }


}
