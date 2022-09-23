<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\CouponRequest;
use App\Repositories\Admin\Coupon\CouponInterface;
class CouponController extends BaseController
{
    protected $couponInt;

    public function __construct(CouponInterface $couponInt)
    {
        $this->couponInt        = $couponInt;
    }

    public function getIndex(Request $request)
    {
        $this->resp = $this->couponInt->getPaginatedList($request);
        return view('admin.coupon.index')->withRows($this->resp->data);
    }

    public function getCreate()
    {
        if(Auth::user()->USER_TYPE ==10){
            $shop_id =Auth::user()->SHOP_ID;
            $branch = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }

        $data['branch'] = $branch;
        return view('admin.coupon.create', compact('data'));
    }

    public function postStore(CouponRequest $request)
    {
        $this->resp = $this->couponInt->postStore($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getEdit($id)
    {
        if(Auth::user()->USER_TYPE ==10){
            $shop_id =Auth::user()->SHOP_ID;
            $branch = DB::table('SA_USER')->where('PK_NO',$shop_id)->pluck('SHOP_NAME', 'PK_NO');
        }else{
            $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        }
        $data['branch'] = $branch;
        $this->resp = $this->couponInt->findOrThrowException($id);
        return view('admin.coupon.edit', compact('data'))->withRow($this->resp->data);
    }

    public function getView($id)
    {
        $this->resp = $this->couponInt->getView($id);
        return view('admin.coupon.view')->withRow($this->resp->data);
    }

    public function postUpdate(CouponRequest $request, $PK_NO) {
        $this->resp = $this->couponInt->postUpdate($request, $PK_NO);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getDelete($id) {
        $this->resp = $this->couponInt->delete($id);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function getAddProduct($id)
    {
        $this->resp = $this->couponInt->findOrThrowException($id);
        \Session::put('list_type', '');
        return view('admin.offer_primary.add_product')->withRow($this->resp->data);
    }

    public function getVariantList(Request $request)
    {
        $this->resp = $this->couponInt->getVariantList($request);
        return response()->json($this->resp);
    }

    public function postCouponSearch(Request $request)
    {
        $this->resp = $this->couponInt->postCouponSearch($request);
        return response()->json($this->resp);
    }

    public function postCouponMasterVariant(Request $request)
    {
        $this->resp = $this->couponInt->postCouponMasterVariant($request);
        return response()->json($this->resp);
    }

    public function postStoreProduct(Request $request)
    {
        $this->resp = $this->couponInt->postStoreProduct($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);

    }

    public function getDeleteProduct($id) {

        $this->resp = $this->couponInt->getDeleteProduct($id);
        return redirect()->back()->with($this->resp->redirect_class, $this->resp->msg);
    }
}
