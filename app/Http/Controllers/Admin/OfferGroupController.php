<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AccountSource;
use App\Models\Offer;
use App\Models\OfferGroup;
use App\Models\OfferPrimary;
use App\Models\OfferSecondary;
use App\Models\OfferType;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\OffergroupRequest;
use App\Repositories\Admin\Offer\OfferInterface;
use App\Repositories\Admin\OfferGroup\OfferGroupInterface;

class OfferGroupController extends BaseController
{
    protected $offerInt;
    protected $offerPrimary;
    protected $offerSecondary;
    protected $offerType;
    protected $offerGroup;

    public function __construct(OfferInterface $offerInt, AccountSource $accountSource, OfferPrimary $offerPrimary , OfferSecondary $offerSecondary, OfferType $offerType, OfferGroupInterface $offerGroup)
    {
        $this->offerInt         = $offerInt;
        $this->accountSource    = $accountSource;
        $this->offerPrimary     = $offerPrimary;
        $this->offerSecondary   = $offerSecondary;
        $this->offerType        = $offerType;
        $this->offerGroup       = $offerGroup;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->offerGroup->getPaginatedList($request);
        return view('admin.offer-group.index')->withRows($this->resp->data);
    }

    public function getCreate()
    {
        $data                       = array();
        $data['offers']             = Offer::whereNull('F_BUNDLE_GROUP_NO')->pluck('BUNDLE_NAME_PUBLIC','PK_NO');
        return view('admin.offer-group.create',compact('data'));
    }

    public function getEdit($id)
    {
        $data                       = array();
        $data['row']                = OfferGroup::find($id);
        $data['select_offers']      = Offer::where('F_BUNDLE_GROUP_NO',$id)->pluck('PK_NO');
        $data['offers']             = Offer::whereNull('F_BUNDLE_GROUP_NO')->orWhere('F_BUNDLE_GROUP_NO',$id)->pluck('BUNDLE_NAME_PUBLIC','PK_NO');
        return view('admin.offer-group.edit',compact('data'));
    }


    public function postStore(OffergroupRequest $request)
    {
        $this->resp = $this->offerGroup->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function postUpdate(OffergroupRequest $request, $pk_no) {
        $this->resp = $this->offerGroup->postUpdate($request, $pk_no);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDelete($pk_no) {

        $this->resp = $this->offerGroup->delete($pk_no);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }


}
