<?php
namespace App\Repositories\Admin\Merchant;

use DB;
use App\Models\Auth;
use App\Models\Merchant;
use App\Traits\RepoResponse;
use App\Models\AuthUserGroup;
use Illuminate\Support\Facades\Hash;

class MerchantAbstract implements MerchantInterface
{
    use RepoResponse;

    protected $merchant;

    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = $this->merchant->orderBy('NAME', 'ASC')->get();
        return $this->formatResponse(true, '', 'merchant.list', $data);
    }



    public function postStore($request)
    {
        DB::beginTransaction();
        try {
            $item                  = new Merchant();
            $item->NAME            = $request->customername;
            $item->MOBILE_NO       = $request->mobileno;
            $item->ALTERNATE_NO    = $request->altno;
            $item->EMAIL           = $request->email;
            $item->FB_ID           = $request->fbid;
            $item->IG_ID           = $request->insid;
            $item->UKSHOP_PASS     = Hash::make($request->ukpass);
            $item->SHORT_NAME      = $request->short_name;
            $item->IS_ACTIVE       = 1;
            $item->save();

            $auth = new Auth();
            $auth->NAME     = $request->customername;
            $auth->MOBILE_NO    = $request->mobileno;
            $auth->EMAIL        = $request->email;
            $auth->PASSWORD     = Hash::make($request->ukpass);
            $auth->DESIGNATION  = 'Merchant';
            $auth->GENDER       = 1;
            $auth->CAN_LOGIN    = 1;
            $auth->STATUS       = 1;
            $auth->FIRST_NAME   = $request->customername;
            $auth->F_MERCHANT_NO= $item->PK_NO;
            $auth->PROFILE_PIC_URL = url('media/images/profile/computer-icons-user-profile-clip-art.jpg');
            $auth->PROFILE_PIC  = 'computer-icons-user-profile-clip-art.jpg';
            $auth->save();

            $roleAuth               = new AuthUserGroup();
            $roleAuth->F_USER_NO    = $auth->PK_NO;
            $roleAuth->F_GROUP_NO   = 14;
            $roleAuth->save();

            DB::table('SS_INV_USER_MAP')->insert([
                'F_INV_WAREHOUSE_NO'=> 2,
                'F_USER_NO'         => $auth->PK_NO,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.merchant.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Merchant has been created successfully !', 'admin.merchant.list');
    }


    public function postUpdate($request, $PK_NO)
    {
        DB::beginTransaction();
        try {
            $item                  = Merchant::find($PK_NO);
            $auth                  = Auth::where('F_MERCHANT_NO',$PK_NO)->first();
            $item->NAME            = $request->customername;
            $item->MOBILE_NO       = $request->mobileno;
            $item->ALTERNATE_NO    = $request->altno;
            $item->EMAIL           = $request->email;
            $item->FB_ID           = $request->fbid;
            $item->IG_ID           = $request->insid;
            $item->SHORT_NAME      = $request->short_name;

            $auth->NAME        = $request->customername;
            $auth->FIRST_NAME      = $request->customername;
            $auth->MOBILE_NO       = $request->mobileno;
            $auth->EMAIL           = $request->email;
            $auth->FACEBOOK_ID     = $request->fbid;

            if($request->ukpass){
                $item->UKSHOP_PASS = Hash::make($request->ukpass);
                $auth->PASSWORD    = Hash::make($request->ukpass);
            }
            $item->save();
            $auth->save();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.merchant.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Merchant has been updated successfully !', 'admin.merchant.list');
    }

    /*

    public function delete($PK_NO)
    {
        $accSource = AccountSource::where('PK_NO',$PK_NO)->first();
        $accSource->IS_ACTIVE = 0;
        if ($accSource->update()) {
            return $this->formatResponse(true, 'Successfully deleted Payment Source', 'admin.account.list');
        }
        return $this->formatResponse(false,'Unable to delete Payment Source','admin.account.list');
    }

    */
}
