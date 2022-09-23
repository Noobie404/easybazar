<?php
namespace App\Repositories\Admin\NewArival;

use DB;
use App\User;
use App\Models\Product;
use App\Models\NewArival;
use App\Traits\RepoResponse;
use App\Models\ProductVariant;
use App\Models\NewArivalMasterDetail;
use App\Models\NewArivalVariantDetail;

class NewArivalAbstract implements NewArivalInterface
{
    use RepoResponse;
    public function __construct()
    {
    }

    public function newArivalCreate($request)
    {
        DB::beginTransaction();
        try {
            $limit = $request->max_variant ?? 500;
            $branch_id = $request->branch_id;
            $branch = User::find($request->branch_id);
            if($request->to_date){
                $to_date = date('Y-m-d', strtotime($request->to_date));
            }else{
                $to_date = date('Y-m-d');
            }
            if($request->from_date){
                $from_date = date('Y-m-d', strtotime($request->from_date));
            }else{
                $from_date = date('2021-01-01');
            }

            $variant = DB::table('PRD_VARIANT_SETUP')
            ->select('PRD_VARIANT_SETUP.PK_NO', 'PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO','PRD_VARIANT_SETUP.VARIANT_NAME', 'PRD_VARIANT_SETUP.SS_CREATED_ON')
            ->join('PRD_SHOP_VARIANT_MAP', function($join) use ($branch_id){
                $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO');
                $join->on('PRD_SHOP_VARIANT_MAP.F_SHOP_NO','=',DB::raw($branch_id));

            })

            ->where('PRD_VARIANT_SETUP.SS_CREATED_ON', '<', $to_date)
            ->where('PRD_VARIANT_SETUP.SS_CREATED_ON', '>', $from_date)
            ->orderBy('PRD_VARIANT_SETUP.SS_CREATED_ON', 'DESC');

            if($limit){
                $variant = $variant->take($limit)->get();
                $order_limit = $order_limit1 = $limit*5;
            }else{
                $variant = $variant->get();
                $order_limit = $order_limit1 = 5000;
            }

            if($variant){
                NewArival::where('F_SHOP_NO',$branch_id)->delete();
                NewArivalVariantDetail::where('F_SHOP_NO',$branch_id)->delete();
                NewArivalMasterDetail::where('F_SHOP_NO',$branch_id)->delete();

                $na                      = new NewArival();
                $na->FROM_DATE           = $from_date;
                $na->TO_DATE             = $to_date;
                $na->MAX_VARIANT         = $limit;
                $na->SS_CREATED_ON       = date('Y-m-d H:i:s');
                $na->F_SS_CREATED_BY     = 1;
                $na->F_SHOP_NO           = $branch->PK_NO;
                $na->SHOP_NAME             = $branch->SHOP_NAME;
                $na->HAS_CHILD           = 1;
                $na->save();
                $id = $na->PK_NO;

                foreach($variant as $key => $row){
                    $child                          = new NewArivalVariantDetail();
                    $child->F_NA_MASTER_NO          = $id;
                    $child->F_PRD_MASTER_SETUP_NO   = $row->F_PRD_MASTER_SETUP_NO;
                    $child->F_PRD_VARIANT_NO            = $row->PK_NO;
                    $child->VARIANT_NAME            = $row->VARIANT_NAME;
                    $child->VARIANT_CREATED_ON      = $row->SS_CREATED_ON;
                    $child->ORDER_ID                = $order_limit-5;
                    $child->F_SHOP_NO               = $branch->PK_NO;
                    $child->SHOP_NAME                 = $branch->SHOP_NAME;
                    $child->save();
                    $order_limit = $order_limit - 5;
                }

                $na_master = NewArivalVariantDetail::select('F_PRD_MASTER_SETUP_NO', DB::raw('COUNT(*) as TOTAL_SELL_VARIANT'))->where('F_NA_MASTER_NO',$id)->groupBy('F_PRD_MASTER_SETUP_NO')->orderBy('VARIANT_CREATED_ON', 'DESC')->get();

                if($na_master){
                    $count_na = $na_master->count();
                    $order_limit2 = $count_na*5;
                    foreach($na_master as $k1 => $row1){
                        DB::table('PRD_NA_MASTER_DETAIL')->insert([
                            'F_NA_MASTER_NO'            => $id,
                            'F_PRD_MASTER_SETUP_NO'     => $row1->F_PRD_MASTER_SETUP_NO,
                            'TOTAL_NA_VARIANT'          => $row1->TOTAL_SELL_VARIANT,
                            'F_SHOP_NO'                 => $branch->PK_NO,
                            'SHOP_NAME'                   => $branch->SHOP_NAME,
                        ]);
                        $order_limit2 = $order_limit2 - 5;
                    }

                    $na_master = NewArivalMasterDetail::where('F_NA_MASTER_NO', $id)->orderBy('TOTAL_NA_VARIANT', 'DESC')->get();
                    if($na_master){
                        $order_limit2 = $count_na*5;
                        foreach($na_master as $k2 => $row2){
                            $ord    = $order_limit2-5;
                            NewArivalMasterDetail::where('PK_NO',$row2->PK_NO)->update(['ORDER_ID' => $ord ]);
                            $order_limit2 = $order_limit2 - 5;
                        }
                    }

                }
            }

        } catch (\Exception $e) {
            dd( $e);
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.newarival.list');
        }
            DB::commit();
        return $this->formatResponse(true, 'Successfully generated New arival report', 'admin.newarival.list');


    }

    public function newArivalDelete($request){
        DB::beginTransaction();
        try {
            $draft_decords_array = $request->draft;
            $master = NewArivalMasterDetail::whereIn('PK_NO', $draft_decords_array)->get();
            if($master){
                foreach($master as $k => $row){
                    NewArivalVariantDetail::where('F_NA_MASTER_NO',$row->F_NA_MASTER_NO)
                    ->where('F_PRD_MASTER_SETUP_NO',$row->F_PRD_MASTER_SETUP_NO)->delete();
                }
            }

            NewArivalMasterDetail::whereIn('PK_NO', $draft_decords_array)->delete();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.newarival.list');
        }
            DB::commit();
        return $this->formatResponse(true, 'New arival list deleted successfully !', 'admin.newarival.list');
    }

    public function newArivalVariantDelete($request){
        DB::beginTransaction();
        try {
            $draft_decords_array = $request->draft;
            $variants = NewArivalVariantDetail::whereIn('PK_NO', $draft_decords_array)->get();
            NewArivalVariantDetail::whereIn('PK_NO', $draft_decords_array)->delete();

            if($variants){
                foreach($variants as $key =>  $prod){
                    $total_varint =  NewArivalVariantDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_NA_MASTER_NO',$prod->F_NA_MASTER_NO)->count();

                    NewArivalMasterDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_NA_MASTER_NO',$prod->F_NA_MASTER_NO)->update(['TOTAL_NA_VARIANT' => $total_varint]);

                }
            }



        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.newarival.list');
        }
            DB::commit();
        return $this->formatResponse(true, 'New arival list deleted successfully !', 'admin.newarival.list');
    }

    public function newArivalOrderidUpdate($request){
        DB::beginTransaction();
        try {
            NewArivalMasterDetail::where('PK_NO', $request->pk_no)->update(['ORDER_ID' => $request->order_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.newarival.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'New arival list order id updated successfully !', 'admin.newarival.list');
    }

    public function newArivalVariantOrderidUpdate($request){
        DB::beginTransaction();
        try {
            NewArivalVariantDetail::where('PK_NO', $request->pk_no)->update(['ORDER_ID' => $request->order_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.newarival.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'New arival list order id updated successfully !', 'admin.newarival.list');
    }


    public function postNewArivalMasterStore($request){
        DB::beginTransaction();
        try {
            if($request->product_id){
                foreach($request->product_id as $k => $item){
                    $child = NewArivalMasterDetail::where('F_PRD_MASTER_SETUP_NO',$item)->first();
                    $na = NewArival::find($request->na_master);
                    if($child == null){
                        $prod  = Product::find($item);
                        $max_order = NewArivalMasterDetail::max('ORDER_ID')+5;
                        $child                          = new NewArivalMasterDetail();
                        $child->F_NA_MASTER_NO          = $request->na_master;
                        $child->F_PRD_MASTER_SETUP_NO   = $prod->PK_NO;
                        $child->IS_MANUAL               = 1;
                        $child->QTY                     = 0;
                        $child->SELL_AMOUNT             = 0;
                        $child->F_SHOP_NO               = $na->F_SHOP_NO;
                        $child->SHOP_NAME               = $na->SHOP_NAME;
                        $child->ORDER_ID                = $max_order;
                        $child->save();

                        //insert variantsl
                        $prods = ProductVariant::select('PRD_VARIANT_SETUP.*')->where('PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO',$item)
                        ->join('PRD_SHOP_VARIANT_MAP', 'PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO','PRD_VARIANT_SETUP.PK_NO')
                        ->where('PRD_SHOP_VARIANT_MAP.F_SHOP_NO',$na->F_SHOP_NO)
                        ->get();

                        if($prods && count($prods)>0){
                            foreach ($prods as $key => $prod) {
                                $max_order  = NewArivalVariantDetail::max('ORDER_ID')+5;
                                $veriant                          = new NewArivalVariantDetail();
                                $veriant->F_NA_MASTER_NO   = $request->na_master;
                                $veriant->F_PRD_VARIANT_NO        = $prod->PK_NO;
                                $veriant->VARIANT_NAME            = $prod->VARIANT_NAME;
                                $veriant->IS_MANUAL               = 1;
                                $veriant->QTY                     = 0;
                                $veriant->SELL_AMOUNT             = 0;
                                $veriant->ORDER_ID                = $max_order;
                                $veriant->F_PRD_MASTER_SETUP_NO   = $prod->F_PRD_MASTER_SETUP_NO;
                                $veriant->F_SHOP_NO               = $na->F_SHOP_NO;
                                $veriant->SHOP_NAME               = $na->SHOP_NAME;
                                $veriant->save();

                                $total_varint =  NewArivalVariantDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_NA_MASTER_NO',$request->na_master)->count();
                                // dd($total_varint);
                                NewArivalMasterDetail::where('F_PRD_MASTER_SETUP_NO',$item)->where('F_SHOP_NO',$na->F_SHOP_NO)->update(['TOTAL_NA_VARIANT' => $total_varint]);
                            }
                        }

                    }

                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.newarival.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product added to new arival list successfully !', 'admin.newarival.list');
    }

    public function postNewArivalVaraitnStore($request){
        DB::beginTransaction();
        try {
            if($request->product_id){
                foreach($request->product_id as $k => $item){
                    $f_na_master_no = $request->na_master;
                    $child      = NewArivalVariantDetail::where('F_PRD_VARIANT_NO',$item)->where('F_NA_MASTER_NO',$f_na_master_no)->first();
                    if($child == null){
                        $prod       = ProductVariant::find($item);
                        $max_order  = NewArivalVariantDetail::max('ORDER_ID')+5;
                        $child                          = new NewArivalVariantDetail();
                        $child->F_NA_MASTER_NO          = $f_na_master_no;
                        $child->F_PRD_VARIANT_NO            = $prod->PK_NO;
                        $child->VARIANT_NAME            = $prod->VARIANT_NAME;
                        $child->IS_MANUAL               = 1;
                        $child->ORDER_ID                = $max_order;
                        $child->F_PRD_MASTER_SETUP_NO   = $prod->F_PRD_MASTER_SETUP_NO;
                        $child->save();

                        $total_varint =  NewArivalVariantDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_NA_MASTER_NO',$f_na_master_no)->count();

                        NewArivalMasterDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_NA_MASTER_NO',$f_na_master_no)->update(['TOTAL_NA_VARIANT' => $total_varint]);

                    }

                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.newarival.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product added to new list successfully !', 'admin.newarival.list');
    }





}

