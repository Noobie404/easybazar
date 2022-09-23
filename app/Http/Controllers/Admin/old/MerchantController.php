<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Models\Country;
use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MerchantRequest;
use App\Repositories\Admin\Merchant\MerchantInterface;





class MerchantController extends Controller
{

    protected $merchant;
    protected $country;

    public function __construct(MerchantInterface $merchant, Country $country)
    {
        $this->merchant     = $merchant;
        $this->country     = $country;
    }

    public function getIndex(Request $request){

        $this->resp = $this->merchant->getPaginatedList($request);
        $data['rows'] = $this->resp->data;
        return view('admin.merchant.index',compact('data'));
    }
    public function getCreate() {
        $data['country'] = $this->country->getCountryComboWithCode();
        return view('admin.merchant.create')->withData($data);
    }
    public function postStore(MerchantRequest $request) {
        $this->resp = $this->merchant->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }
    public function getEdit($id) {
        $data['country'] = $this->country->getCountryComboWithCode();
        $data['row'] = Merchant::find($id);
        return view('admin.merchant.edit')->withData($data);
    }
    public function postUpdate(MerchantRequest $request, $id) {
        $this->resp = $this->merchant->postUpdate($request, $id);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }










}
