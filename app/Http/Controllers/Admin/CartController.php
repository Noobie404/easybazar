<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\AddToCartRequest;
use App\Repositories\Admin\Cart\CartInterface;
use App\Http\Requests\Admin\FlatDiscountRequest;
use App\Http\Requests\Admin\UpdateCartQtyRequest;
use App\Repositories\Admin\Booking\BookingAbstract;
use App\Http\Requests\Admin\PostCouponDiscountRequest;
use App\Repositories\Admin\Category\CategoryInterface;
use App\Repositories\Admin\Customer\CustomerInterface;

class CartController extends BaseController
{
    protected $category;
    protected $customerInt;
    protected $bookingInt;
    protected $cartInt;


    public function __construct(
        BookingAbstract $bookingInt, 
        CartInterface $cartInt, 
        CustomerInterface $customerInt, 
        CategoryInterface $category)
    {
        $this->bookingInt         = $bookingInt;
        $this->customerInt         = $customerInt;
        $this->category         = $category;
        $this->cartInt         = $cartInt;
    }

    public function getCart(Request $request, $id = null, $type = null)
    {
          if(Auth::user()->USER_TYPE == 10 ){
            $shop_id  = Auth::user()->SHOP_ID;
            $branch = DB::table('SA_USER')->where('PK_NO',$shop_id)->get();
        }else{
            $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->get();
        }
        $category = $this->category->getPaginatedList($request);
        $categories = $category->data['data'];
        $delivery_schedules = DB::table('SLS_DELIVERY_SCHEDULE')->orderBy('SLOT_TO','ASC')->get(); 
        return view('admin.cart.index',compact('categories','branch','delivery_schedules'));
    }

    public function addToCart(AddToCartRequest $request){
        $this->resp = $this->cartInt->addToCart($request);
        return response()->json($this->resp);
    }

    public function removeCart(Request $request){

        $this->resp = $this->cartInt->removeCart($request);
        
        return response()->json($this->resp);

    }
    public function updateCartQty(UpdateCartQtyRequest $request){
        $this->resp = $this->cartInt->updateCartQty($request);
           return response()->json($this->resp);
    }

    public function getCartDetails(Request $request)
    {
        $response = $this->cartInt->getCartDetails($request);

        return response()->json($response, $response->code);
    }

    public function postFlatDiscount(FlatDiscountRequest $request)
    {
        $response = $this->cartInt->postFlatDiscount($request);

        return response()->json($response, $response->code);
    }

    public function postCouponDiscount(PostCouponDiscountRequest $request)
    {
        $response = $this->cartInt->postCouponDiscount($request);
        return response()->json($response, $response->code);
    }
    public function getRemoveCoupon(Request $request)
    {
        $response = $this->cartInt->getRemoveCoupon($request);
        return response()->json($response, $response->code);
    }



    

    





}
