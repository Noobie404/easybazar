<?php
namespace App\Http\Controllers\Admin;
use DB;
use App\Models\Product;
use App\Models\NewArival;
use App\Traits\RepoResponse;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\NewArivalMasterDetail;
use App\Http\Controllers\BaseController;
use App\Repositories\Admin\NewArival\NewArivalInterface;


class NewarivalController extends BaseController
{
    use RepoResponse;

    private $newArivalInt;


    function __construct(NewArivalInterface $newArivalInt)
    {
        $this->newArivalInt    = $newArivalInt;
    }



    public function getIndex(Request $request)
    {
        $branch = DB::table('SA_USER')->where('USER_TYPE',10)->where('F_PARENT_USER_ID',0)->pluck('SHOP_NAME', 'PK_NO');
        $data['branch'] = $branch;
        return view('admin.newarival.index',compact('data'));
    }


    public function newArivalCreate(Request $request)
    {
        $this->validate($request, [
            'branch_id'     => 'required',
            'from_date'     => 'required',
            'to_date'       => 'required',
            'max_variant'   => 'required',
        ]);

        $this->resp = $this->newArivalInt->newArivalCreate($request);
        return redirect()->route($this->resp->redirect_to)->with($this->resp->redirect_class, $this->resp->msg);
    }

    public function newArivalView(Request $request, $id)
    {
        $data = NewArival::find($id);
        return view('admin.newarival.new_arival_master',compact('data'));
    }

    public function getNewArivalVariant(Request $request, $id)
    {
        $master   = NewArivalMasterDetail::find($id);
        $data['master'] = Product::find($master->F_PRD_MASTER_SETUP_NO);
        $data['na_master'] = $master;
        return view('admin.newarival.newarival_variant_view',compact('data'));
    }

    public function newArivalDelete(Request $request)
    {
        $data =  $this->newArivalInt->newArivalDelete($request);
        return response()->json($data);
    }

    public function newArivalVariantDelete(Request $request)
    {
        $data =  $this->newArivalInt->newArivalVariantDelete($request);
        return response()->json($data);
    }


    public function newArivalOrderidUpdate(Request $request){
        $data = $this->newArivalInt->newArivalOrderidUpdate($request);
        return response()->json($data);
    }

    public function newArivalVariantOrderidUpdate(Request $request){
        $data = $this->newArivalInt->newArivalVariantOrderidUpdate($request);
        return response()->json($data);
    }

    public function postNewArivalMasterStore(Request $request){
        $data = $this->newArivalInt->postNewArivalMasterStore($request);
        return response()->json($data);
    }

    public function postNewArivalVaraitnStore(Request $request){
        $data = $this->newArivalInt->postNewArivalVaraitnStore($request);
        return response()->json($data);
    }


    public function getNewArivalMaster(Request $request)
    {
        $search = $request->search;
        $na_master = $request->na_master;
        $na = NewArival::find($na_master);
        $f_shop_no = $na->F_SHOP_NO;

        if($search == ''){
           $products = Product::select('PRD_MASTER_SETUP.PK_NO','PRD_MASTER_SETUP.DEFAULT_NAME')
           ->join('PRD_SHOP_MASTER_MAP', function($join) use ($f_shop_no){
                $join->on('PRD_MASTER_SETUP.PK_NO', '=', 'PRD_SHOP_MASTER_MAP.F_PRD_MASTER_SETUP_NO');
                $join->on('PRD_SHOP_MASTER_MAP.F_SHOP_NO','=',DB::raw($f_shop_no));
            })
            ->leftJoin('PRD_NA_MASTER_DETAIL', function($join) use ($f_shop_no){
                $join->on('PRD_MASTER_SETUP.PK_NO', '=', 'PRD_NA_MASTER_DETAIL.F_PRD_MASTER_SETUP_NO');
                $join->on('PRD_NA_MASTER_DETAIL.F_SHOP_NO','=',DB::raw($f_shop_no));
            })
           ->whereNull('PRD_NA_MASTER_DETAIL.F_NA_MASTER_NO')
           ->orderby('PRD_MASTER_SETUP.DEFAULT_NAME','asc')
           ->limit(20)
           ->get();

        }else{
            $products = Product::select('PRD_MASTER_SETUP.PK_NO','PRD_MASTER_SETUP.DEFAULT_NAME')
            ->join('PRD_SHOP_MASTER_MAP', function($join) use ($f_shop_no){
                 $join->on('PRD_MASTER_SETUP.PK_NO', '=', 'PRD_SHOP_MASTER_MAP.F_PRD_MASTER_SETUP_NO');
                 $join->on('PRD_SHOP_MASTER_MAP.F_SHOP_NO','=',DB::raw($f_shop_no));
             })
             ->leftJoin('PRD_NA_MASTER_DETAIL', function($join) use ($f_shop_no){
                 $join->on('PRD_MASTER_SETUP.PK_NO', '=', 'PRD_NA_MASTER_DETAIL.F_PRD_MASTER_SETUP_NO');
                 $join->on('PRD_NA_MASTER_DETAIL.F_SHOP_NO','=',DB::raw($f_shop_no));
             })
            ->whereNull('PRD_NA_MASTER_DETAIL.F_NA_MASTER_NO')
            ->orderby('PRD_MASTER_SETUP.DEFAULT_NAME','asc');

           $pieces = explode(" ", $search);
           if($pieces){
               foreach ($pieces as $key => $piece) {
                $products->where('PRD_MASTER_SETUP.DEFAULT_NAME', 'LIKE', '%' . $piece . '%');
               }
           }
           $products = $products->limit(20)->get();
        }
        $response = array();
        foreach($products as $item){
            $response[] = array(
                "id"=>$item->PK_NO,
                "text"=>$item->DEFAULT_NAME
            );
        }
        return response()->json($response);
    }

    public function getNotNewArivalVariant(Request $request, $id)
    {
        $na_master   = NewArivalMasterDetail::find($id);
        $master_no = $na_master->F_PRD_MASTER_SETUP_NO;
        $f_na_master_no = $na_master->F_NA_MASTER_NO;
        $search = $request->search;
        if($search == ''){
           $products = ProductVariant::select('PRD_VARIANT_SETUP.PK_NO','PRD_VARIANT_SETUP.VARIANT_NAME')
           ->leftJoin('PRD_NA_VARIANT_DETAIL', function($join) use ($master_no,$f_na_master_no){
                $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_NA_VARIANT_DETAIL.F_VARIANT_NO');
                $join->on('PRD_NA_VARIANT_DETAIL.F_PRD_MASTER_SETUP_NO','=',DB::raw($master_no));
                $join->on('PRD_NA_VARIANT_DETAIL.F_NA_MASTER_NO','=',DB::raw($f_na_master_no));
            })
           ->whereNull('PRD_NA_VARIANT_DETAIL.F_NA_MASTER_NO')
           ->where('PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO',$master_no)
           ->orderby('PRD_VARIANT_SETUP.VARIANT_NAME','ASC')
           ->limit(20)
           ->get();
        }else{

           $products = ProductVariant::select('PRD_VARIANT_SETUP.PK_NO','PRD_VARIANT_SETUP.VARIANT_NAME')
           ->leftJoin('PRD_NA_VARIANT_DETAIL', function($join) use ($master_no,$f_na_master_no){
                $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_NA_VARIANT_DETAIL.F_VARIANT_NO');
                $join->on('PRD_NA_VARIANT_DETAIL.F_PRD_MASTER_SETUP_NO','=', DB::raw($master_no));
                $join->on('PRD_NA_VARIANT_DETAIL.F_NA_MASTER_NO','=', DB::raw($f_na_master_no));
            })
          ->whereNull('PRD_NA_VARIANT_DETAIL.F_NA_MASTER_NO')
           ->where('PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO',$master_no)
           ->orderby('PRD_VARIANT_SETUP.VARIANT_NAME','ASC');

           $pieces = explode(" ", $search);
           if($pieces){
               foreach ($pieces as $key => $piece) {
                $products->where('PRD_VARIANT_SETUP.VARIANT_NAME', 'LIKE', '%' . $piece . '%');
               }
           }
           $products = $products->limit(20)->get();
        }

        $response = array();
        foreach($products as $item){
           $response[] = array(
                "id"=>$item->PK_NO,
                "text"=>$item->VARIANT_NAME
           );
        }
        return response()->json($response);
    }




}

