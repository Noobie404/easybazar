<?php

namespace App\Http\Controllers\Admin;

use App\Seller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\VendorRequest;
use App\Repositories\Admin\Vendor\VendorInterface;

class VendorController extends BaseController
{
    protected $vendor;
    protected $country;

    public function __construct(VendorInterface $vendor, Country $country)
    {
        $this->vendor   = $vendor;
        $this->country  = $country;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->vendor->getPaginatedList($request, 20);

        if(Auth::user()->USER_TYPE ==10){
            $shop_id =Auth::user()->SHOP_ID;
            $branch = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }
        return view('admin.procurement.vendor.index')
            ->withRows($this->resp->data)->withBranch($branch);
    }

    public function getCreate() {
        $country = $this->country->getCountryCombo();
        if(Auth::user()->USER_TYPE ==10){
            $shop_id =Auth::user()->SHOP_ID;
            $branch = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }

        return view('admin.procurement.vendor.create')
            ->withCountry($country)
            ->withBranch($branch);
    }

    public function postStore(VendorRequest $request) {

        $this->resp = $this->vendor->postStore($request);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit(Request $request, $id)
    {
        $this->resp = $this->vendor->findOrThrowException($id);
        $country    = $this->country->getCountryCombo();

        if(Auth::user()->USER_TYPE ==10){
            $shop_id =Auth::user()->SHOP_ID;
            $branch = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }

        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.procurement.vendor.edit')
            ->withVendor($this->resp->data)
            ->withCountry($country)
            ->withBranch($branch);
    }

    public function getView(Request $request, $id)
    {
        $this->resp = $this->vendor->findOrThrowException($id);
        $country    = $this->country->getCountryCombo();
        if (!$this->resp->status) {
            return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
        }
        return view('admin.procurement.vendor.view')
            ->withVendor($this->resp->data)
            ->withCountry($country);
    }

    public function postUpdate(VendorRequest $request, $id)
    {
        $this->resp = $this->vendor->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDelete($id)
    {
        $this->resp = $this->vendor->delete($id);

        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

}
