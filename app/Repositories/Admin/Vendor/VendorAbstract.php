<?php
namespace App\Repositories\Admin\Vendor;

use DB;
use Auth;
use App\Models\Vendor;
use App\Traits\RepoResponse;

class VendorAbstract implements VendorInterface
{
    use RepoResponse;
    protected $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function getPaginatedList($request, int $per_page = 20)
    {

        $data = $this->vendor->where('PRC_VENDORS.IS_ACTIVE',1)
        ->select('PRC_VENDORS.PK_NO','PRC_VENDORS.CODE','PRC_VENDORS.NAME', 'PRC_VENDORS.ADDRESS', 'PRC_VENDORS.PHONE', 'PRC_VENDORS.COUNTRY', 'PRC_VENDORS.HAS_LOYALITY','SA_USER.SHOP_NAME')
        ->leftJoin('SA_USER','SA_USER.PK_NO','PRC_VENDORS.F_SHOP_NO');

        if(Auth::user()->USER_TYPE == 10){
            $shop_no = Auth::user()->SHOP_ID;
            $data->where('PRC_VENDORS.F_SHOP_NO',$shop_no);
        }else{
            if($request->branch_id){
                $data->where('PRC_VENDORS.F_SHOP_NO',$request->branch_id);
            }
        }

        $data = $data->orderBy('PRC_VENDORS.NAME', 'ASC')
        ->get();

        return $this->formatResponse(true, '', 'admin.vendor', $data);
    }

    public function getSellerPaginatedList($request, int $per_page = 20)
    {
        $data = $this->vendor->where('IS_ACTIVE',1)->select('PK_NO','CODE','NAME', 'ADDRESS', 'PHONE', 'COUNTRY', 'HAS_LOYALITY')->orderBy('NAME', 'ASC')->get();
        return $this->formatResponse(true, '', 'admin.vendor', $data);
    }

    public function postStore($request)
    {
        $country = DB::table('SS_COUNTRY')->select('NAME')->where('PK_NO', '=', $request->country)->first();
        DB::beginTransaction();
        try {
            $vendor = new Vendor();
            $vendor->F_SHOP_NO      = $request->branch_id;
            $vendor->NAME           = $request->name;
            $vendor->ADDRESS        = $request->address;
            $vendor->F_COUNTRY      = $request->country;
            $vendor->COUNTRY        = $country->NAME;
            $vendor->PHONE          = $request->phone;
            $vendor->HAS_LOYALITY   = $request->has_loyality;
            $vendor->save();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create vendor !', 'admin.vendor');
        }
        DB::commit();
        return $this->formatResponse(true, 'Vendor has been created successfully !', 'admin.vendor');
    }

    public function postSellerStore($request)
    {
        $country = DB::table('SS_COUNTRY')->select('NAME')->where('PK_NO', '=', $request->country)->first();
        DB::beginTransaction();
        try {
            $vendor = new Vendor();
            $vendor->F_SHOP_NO      = $request->branch_id;
            $vendor->NAME           = $request->name;
            $vendor->ADDRESS        = $request->address;
            $vendor->F_COUNTRY      = $request->country;
            $vendor->COUNTRY        = $country->NAME;
            $vendor->PHONE          = $request->phone;
            $vendor->HAS_LOYALITY   = $request->has_loyality;
            $vendor->save();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create vendor !', 'seller.vendor');
        }
        DB::commit();
        return $this->formatResponse(true, 'Vendor has been created successfully !', 'seller.vendor');
    }

    public function findOrThrowException($id)
    {
        $data = $this->vendor->where('PK_NO', '=', $id)->first();
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.vendor.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.vendor', null);
    }

    public function postUpdate($request, $id)
    {
        $country = DB::table('SS_COUNTRY')->select('NAME')->where('PK_NO', '=', $request->country)->first();
        DB::beginTransaction();
        try {
            $vendor = $this->vendor->find($id);
            if($vendor->NAME != $request->name ){
                DB::table('MER_PRC_STOCK_IN')->where('F_VENDOR_NO',$id)->update(['VENDOR_NAME' => $request->name]);
                DB::table('PRC_STOCK_IN')->where('F_VENDOR_NO',$id)->update(['VENDOR_NAME' => $request->name]);
            }
            $vendor->NAME           = $request->name;
            $vendor->ADDRESS        = $request->address;
            $vendor->F_COUNTRY      = $request->country;
            $vendor->COUNTRY        = $country->NAME;
            $vendor->PHONE          = $request->phone;
            $vendor->HAS_LOYALITY   = $request->has_loyality;
            $vendor->update();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update vendor !', 'admin.vendor');
        }

        DB::commit();
        return $this->formatResponse(true, 'Vendor has been updated successfully !', 'admin.vendor');
    }

    public function delete($id)
    {
        DB::begintransaction();
        try {
            $vendor = Vendor::find($id)->delete();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete the vendor !', 'admin.vendor');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete the vendor !', 'admin.vendor');
    }

    public function postSellerUpdate($request, $id)
    {
        $country = DB::table('SS_COUNTRY')->select('NAME')->where('PK_NO', '=', $request->country)->first();
        DB::beginTransaction();
        try {
            $vendor = $this->vendor->find($id);
            if($vendor->NAME != $request->name ){
                DB::table('MER_PRC_STOCK_IN')->where('F_VENDOR_NO',$id)->update(['VENDOR_NAME' => $request->name]);
                DB::table('PRC_STOCK_IN')->where('F_VENDOR_NO',$id)->update(['VENDOR_NAME' => $request->name]);
            }
            $vendor->NAME           = $request->name;
            $vendor->ADDRESS        = $request->address;
            $vendor->F_COUNTRY      = $request->country;
            $vendor->COUNTRY        = $country->NAME;
            $vendor->PHONE          = $request->phone;
            $vendor->HAS_LOYALITY   = $request->has_loyality;
            $vendor->update();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to update vendor !', 'seller.vendor');
        }

        DB::commit();
        return $this->formatResponse(true, 'Vendor has been updated successfully !', 'seller.vendor');
    }


    public function sellerDelete($id)
    {
        DB::begintransaction();
        try {
            $vendor = $this->vendor->find($id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete the vendor !', 'seller.vendor');
        }
        DB::commit();

        return $this->formatResponse(true, 'Successfully delete the vendor !', 'seller.vendor');
    }


}
