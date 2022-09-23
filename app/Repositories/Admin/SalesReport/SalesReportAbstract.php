<?php
namespace App\Repositories\Admin\SalesReport;

use DB;
use App\User;
use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\Product;
use App\Models\BestSell;
use App\Traits\RepoResponse;
use App\Models\ProductVariant;
use App\Models\BestSellMasterDetail;
use App\Models\BestSellVariantDetail;

class SalesReportAbstract implements SalesReportInterface
{
    use RepoResponse;
    public function __construct()
    {
    }

    public function getComissionReport($id)
    {
        $agent          = Agent::select('NAME')->where('PK_NO',$id)->first();
        $now            = Carbon::now();
        $current_year   = $now->year;
        $current_month  = $now->month;

        $data['data'] = DB::table('SLS_BOOKING as b')
        ->select('b.SHOP_NAME','b.F_SHOP_NO as agent_no'
        ,DB::raw('(IFNULL(SUM(bd.COMISSION),0)) as current_comission')
        // ,DB::raw('(IFNULL(COUNT(o.PK_NO),0)) as current_order')
        ,DB::raw('(select (IFNULL(COUNT(o.PK_NO),0)) from SLS_BOOKING as b
        inner join SLS_ORDER as o on o.F_BOOKING_NO = b.PK_NO
        where year(b.SS_CREATED_ON) = '.$current_year.'
        and month(b.SS_CREATED_ON) = '.$current_month.'
        and b.F_SHOP_NO = agent_no ) as current_order')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS as bd','bd.F_BOOKING_NO','b.PK_NO')
        ->whereYear('b.SS_CREATED_ON',$current_year)
        ->whereMonth('b.SS_CREATED_ON',$current_month)
        ->where('b.F_SHOP_NO',$id)
        ->groupBy('b.F_SHOP_NO')
        ->first();

        $data['cancelled_later'] = DB::table('SLS_BOOKING as b')
        ->select('b.F_SHOP_NO as agent_no'
        ,DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->whereYear('b.SS_CREATED_ON',$current_year)
        ->whereMonth('b.SS_CREATED_ON',$current_month)
        ->where('b.F_SHOP_NO',$id)
        ->whereRaw('(bda.CHANGE_TYPE = "ORDER_CANCEL")')
        ->groupBy('b.F_SHOP_NO')
        ->first();

        $data['cancelled_now'] = DB::table('SLS_BOOKING as b')
        ->select('b.F_SHOP_NO as agent_no'
        ,DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->whereYear('b.CANCELED_AT',$current_year)
        ->whereMonth('b.CANCELED_AT',$current_month)
        ->where('b.F_SHOP_NO',$id)
        ->whereRaw('(bda.CHANGE_TYPE = "ORDER_CANCEL")')
        ->groupBy('b.F_SHOP_NO')
        ->first();

        $data['return_later'] = DB::table('SLS_BOOKING as b')
        ->select('b.F_SHOP_NO as agent_no'
        ,DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->whereYear('b.SS_CREATED_ON',$current_year)
        ->whereMonth('b.SS_CREATED_ON',$current_month)
        ->where('b.F_SHOP_NO',$id)
        ->whereRaw('(bda.CHANGE_TYPE = "ORDER_RETURN")')
        ->whereIn('bda.RETURN_TYPE',[1,2,4])
        ->groupBy('b.F_SHOP_NO')
        ->first();

        $data['return_now'] = DB::table('SLS_BOOKING as b')
        ->select('b.F_SHOP_NO as agent_no'
        ,DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->whereYear('bda.RETURN_DATE',$current_year)
        ->whereMonth('bda.RETURN_DATE',$current_month)
        ->where('b.F_SHOP_NO',$id)
        ->whereRaw('(bda.CHANGE_TYPE = "ORDER_RETURN")')
        ->whereIn('bda.RETURN_TYPE',[1,2,3,6])
        ->groupBy('b.F_SHOP_NO')
        ->first();

        // if (isset($data['data'])) {
            $current_comission = $data['data']->current_comission ?? 0;
            $current_comission += $data['cancelled_later']->c_current_comission ?? 0;
            $current_comission += $data['return_later']->c_current_comission ?? 0;
            $current_comission -= $data['cancelled_now']->c_current_comission ?? 0;
            $current_comission -= $data['return_now']->c_current_comission ?? 0;
            $data['current_comission'] = $current_comission;
        // }
        $data['total_comission'] = DB::SELECT("SELECT IFNULL(SUM(bd.COMISSION),0) as total_comission, SHOP_NAME FROM SLS_BOOKING as b inner join SLS_ORDER as o on o.F_BOOKING_NO = b.PK_NO inner join SLS_BOOKING_DETAILS as bd on bd.F_BOOKING_NO = b.PK_NO where b.F_SHOP_NO = $id");

        $data['total_order'] = Booking::join('SLS_ORDER','SLS_ORDER.F_BOOKING_NO','SLS_BOOKING.PK_NO')->where('SLS_BOOKING.F_SHOP_NO',$id)->count();

        return $this->formatResponse(true, 'Data Found', 'admin.shipment.shipmentInvoiceView', $data);
    }

    public function ajaxComissionReport($agent_id,$date)
    {
        $current_year   = date('Y', strtotime($date));
        $current_month  = date('n', strtotime($date));

        $count_monthly = DB::table('SLS_BOOKING as b')
        ->select(DB::raw('(IFNULL(SUM(bd.COMISSION),0)) as current_comission')
        // ,DB::raw('(IFNULL(COUNT(o.PK_NO),0)) as current_order')
        ,DB::raw('(select (IFNULL(COUNT(o.PK_NO),0)) from SLS_BOOKING as b
        inner join SLS_ORDER as o on o.F_BOOKING_NO = b.PK_NO
        where year(b.SS_CREATED_ON) = '.$current_year.'
        and month(b.SS_CREATED_ON) = '.$current_month.'
        and b.F_SHOP_NO = '.$agent_id.' ) as current_order')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS as bd','bd.F_BOOKING_NO','b.PK_NO')
        // ->leftjoin('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->whereYear('b.SS_CREATED_ON',$current_year)
        ->whereMonth('b.SS_CREATED_ON',$current_month)
        ->where('b.F_SHOP_NO',$agent_id)
        // ->whereRaw('(bda.CHANGE_TYPE = "ORDER_CANCEL" OR bda.CHANGE_TYPE IS NULL)')
        ->first();

        $data['cancelled_later'] = DB::table('SLS_BOOKING as b')
        ->select('b.F_SHOP_NO as agent_no'
        ,DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->whereYear('b.SS_CREATED_ON',$current_year)
        ->whereMonth('b.SS_CREATED_ON',$current_month)
        ->where('b.F_SHOP_NO',$agent_id)
        ->whereRaw('(bda.CHANGE_TYPE = "ORDER_CANCEL")')
        ->groupBy('b.F_SHOP_NO')
        ->first();

        $data['cancelled_now'] = DB::table('SLS_BOOKING as b')
        ->select('b.F_SHOP_NO as agent_no'
        ,DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->whereYear('b.CANCELED_AT',$current_year)
        ->whereMonth('b.CANCELED_AT',$current_month)
        ->where('b.F_SHOP_NO',$agent_id)
        ->whereRaw('(bda.CHANGE_TYPE = "ORDER_CANCEL")')
        ->groupBy('b.F_SHOP_NO')
        ->first();

        $data['return_later'] = DB::table('SLS_BOOKING as b')
        ->select('b.F_SHOP_NO as agent_no'
        ,DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->whereYear('b.SS_CREATED_ON',$current_year)
        ->whereMonth('b.SS_CREATED_ON',$current_month)
        ->where('b.F_SHOP_NO',$agent_id)
        ->whereRaw('(bda.CHANGE_TYPE = "ORDER_RETURN")')
        ->whereIn('bda.RETURN_TYPE',[1,2,4])
        ->groupBy('b.F_SHOP_NO')
        ->first();

        $data['return_now'] = DB::table('SLS_BOOKING as b')
        ->select('b.F_SHOP_NO as agent_no'
        ,DB::raw('(IFNULL(SUM(bda.COMISSION),0)) as c_current_comission')
        )
        ->join('SLS_ORDER as o','o.F_BOOKING_NO','b.PK_NO')
        ->join('SLS_BOOKING_DETAILS_AUD as bda','bda.F_BOOKING_NO','b.PK_NO')
        ->whereYear('bda.RETURN_DATE',$current_year)
        ->whereMonth('bda.RETURN_DATE',$current_month)
        ->where('b.F_SHOP_NO',$agent_id)
        ->whereRaw('(bda.CHANGE_TYPE = "ORDER_RETURN")')
        ->whereIn('bda.RETURN_TYPE',[1,2,3,6])
        ->groupBy('b.F_SHOP_NO')
        ->first();

        $count_monthly->current_comission += $data['cancelled_later']->c_current_comission ?? 0;
        $count_monthly->current_comission += $data['return_later']->c_current_comission ?? 0;
        $count_monthly->current_comission -= $data['cancelled_now']->c_current_comission ?? 0;
        $count_monthly->current_comission -= $data['return_now']->c_current_comission ?? 0;

        return $count_monthly;
    }

    public function getYetToShip($request)
    {
        if ($request->get('from_date') === null || ($request->get('to_date')) === null) {
            $from_date = new Carbon('last day of last year');
            $from_date = $from_date->startOfMonth()->subSeconds(1)->endOfMonth()->toDateString();

            // $from_date = new Carbon('last year');
            // $from_date = date('F Y', strtotime($from_date));
            // $last_month = Carbon::now()->subMonth()->format('F');
            // $last_year = new Carbon('last year');
            // $last_year = date('Y', strtotime($last_year));
            // $from_date = new Carbon('last day of '.$last_month.' '.$last_year.'');
            // $from_date = $from_date->toDateString();
            // $from_date = $from_date->startOfMonth()->subSeconds(1)->endOfMonth()->toDateString();

            $to_date    = Carbon::now()->firstOfMonth()->toDateString();
        }else{
            $from_date   = date('Y-m-d', strtotime($request->get('from_date')));
            $to_date     = date('Y-m-d', strtotime($request->get('to_date')));
        }
        // $data['invoice_exact'] = DB::table('PRC_STOCK_IN as stock')
        //         // ->leftjoin('PRC_STOCK_IN_DETAILS as details','details.F_PRC_STOCK_IN','stock.PK_NO')
        //         ->where('stock.F_SS_CURRENCY_NO',1)
        //         ->where('stock.INV_STOCK_RECORD_GENERATED',0)
        //         // ->whereBetween('details.SS_CREATED_ON',[$from_date,$to_date])
        //         ->whereBetween('stock.INVOICE_DATE',[$from_date,$to_date])
        //         ->sum('stock.INVOICE_EXACT_VALUE');


        $data['invoice_exact'] = DB::SELECT("SELECT sum(stock.INVOICE_EXACT_VALUE) as invoice_exact
                                    from PRC_STOCK_IN as stock
                                    where stock.F_SS_CURRENCY_NO = 1
                                    and stock.INV_STOCK_RECORD_GENERATED = 0
                                    and stock.INVOICE_DATE between '$from_date' and '$to_date'");
        $data['invoice_exact'] = $data['invoice_exact'][0]->invoice_exact;

        // $data['invoice_actual_ev'] = DB::table('PRC_STOCK_IN as stock')
        //         // ->leftjoin('PRC_STOCK_IN_DETAILS as details','details.F_PRC_STOCK_IN','stock.PK_NO')
        //         ->where('stock.F_SS_CURRENCY_NO',1)
        //         ->where('stock.INV_STOCK_RECORD_GENERATED',0)
        //         // ->whereBetween('details.SS_CREATED_ON',[$from_date,$to_date])
        //         ->whereBetween('stock.INVOICE_DATE',[$from_date,$to_date])
        //         ->sum('stock.INVOICE_TOTAL_EV_ACTUAL_GBP')

        $data['invoice_actual_ev'] = DB::SELECT("SELECT sum(stock.INVOICE_TOTAL_EV_ACTUAL_GBP) as invoice_actual_ev
                                    from PRC_STOCK_IN as stock
                                    where stock.F_SS_CURRENCY_NO = 1
                                    and stock.INV_STOCK_RECORD_GENERATED = 0
                                    and stock.INVOICE_DATE between '$from_date' and '$to_date'");
        $data['invoice_actual_ev'] = $data['invoice_actual_ev'][0]->invoice_actual_ev;

        // $data['in_ship'] = DB::table('INV_STOCK as i')
        //             ->join('SC_SHIPMENT as s','s.PK_NO','i.F_SHIPPMENT_NO')
        //             ->leftjoin('PRC_STOCK_IN as stock','i.F_PRC_STOCK_IN_NO','stock.PK_NO')
        //             ->whereNotNull('i.F_SHIPPMENT_NO')
        //             ->where('stock.F_SS_CURRENCY_NO',1)
        //             ->where('s.SCH_DEPARTING_DATE','<=',$to_date)
        //             ->whereBetween('stock.INVOICE_DATE',[$from_date,$to_date])
        //             ->sum('i.PRODUCT_PURCHASE_PRICE_GBP');

        $data['in_ship'] = DB::SELECT("SELECT sum(i.PRODUCT_PURCHASE_PRICE_GBP) as in_ship
                                from INV_STOCK as i
                                inner join SC_SHIPMENT as s on s.PK_NO = i.F_SHIPPMENT_NO
                                left join PRC_STOCK_IN as stock on i.F_PRC_STOCK_IN_NO = stock.PK_NO
                                where i.F_SHIPPMENT_NO is not null
                                and stock.F_SS_CURRENCY_NO = 1
                                and s.SCH_DEPARTING_DATE <= '$to_date'
                                and stock.INVOICE_DATE between '$from_date' and '$to_date'");
        $data['in_ship'] = $data['in_ship'][0]->in_ship;

        // $data['not_in_ship'] = DB::table('INV_STOCK as i')
        //             ->leftjoin('PRC_STOCK_IN as stock','i.F_PRC_STOCK_IN_NO','stock.PK_NO')
        //             ->leftjoin('SC_SHIPMENT as s','s.PK_NO','i.F_SHIPPMENT_NO')
        //             ->whereRaw('(i.F_SHIPPMENT_NO IS NULL OR s.SCH_DEPARTING_DATE > '.$to_date.')')
        //             ->where('stock.F_SS_CURRENCY_NO',1)
        //             ->whereBetween('stock.INVOICE_DATE',[$from_date,$to_date])
        //             ->sum('i.PRODUCT_PURCHASE_PRICE_GBP');

        $data['not_in_ship'] = DB::SELECT("SELECT sum(i.PRODUCT_PURCHASE_PRICE_GBP) as not_in_ship
                                from INV_STOCK as i
                                left join PRC_STOCK_IN as stock on i.F_PRC_STOCK_IN_NO = stock.PK_NO
                                left join SC_SHIPMENT as s on s.PK_NO = i.F_SHIPPMENT_NO
                                where (i.F_SHIPPMENT_NO IS NULL OR s.SCH_DEPARTING_DATE > '$to_date')
                                and stock.F_SS_CURRENCY_NO = 1
                                and stock.INVOICE_DATE between '$from_date' and '$to_date'");
        $data['not_in_ship'] = $data['not_in_ship'][0]->not_in_ship;


        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        return $this->formatResponse(true, 'Data Found', 'admin.shipment.shipmentInvoiceView', $data);
    }
    public function topSell($request){
        return $data = BestSell::get();
    }

    public function topSellCreate($request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $limit = $request->max_variant ?? 500;
            $from_date = date('2021-01-01');
            $to_date = date('Y-m-d');
            if($request->to_date){
                $to_date = date('Y-m-d', strtotime($request->to_date));
            }
            if($request->from_date){
                // $from_date = date('Y-m-d', strtotime($request->from_date));
            }
            $branch = User::find($request->branch_id);


            $variant = DB::table('INV_STOCK')
            ->select('INV_STOCK.F_PRD_VARIANT_NO', 'INV_STOCK.PRD_VARINAT_NAME','SLS_BOOKING.BOOKING_TIME', DB::raw('count(*) as TOTAL_SELL_QTY'),'PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO',DB::raw(' SUM(INV_STOCK.SPECIAL_PRICE) as TOTAL_SELL_AMOUNT') )
            ->leftJoin('SLS_BOOKING','SLS_BOOKING.PK_NO','INV_STOCK.F_BOOKING_NO')
            ->leftJoin('PRD_VARIANT_SETUP','PRD_VARIANT_SETUP.PK_NO','INV_STOCK.F_PRD_VARIANT_NO')
            ->where('SLS_BOOKING.BOOKING_TIME', '<', $to_date)
            ->where('SLS_BOOKING.BOOKING_TIME', '>', $from_date)
            ->where('SLS_BOOKING.BOOKING_STATUS','>', 0)
            ->where('INV_STOCK.F_SHOP_NO',$request->branch_id)
            ->whereNotNull('INV_STOCK.ORDER_STATUS')
            ->groupBy('INV_STOCK.F_PRD_VARIANT_NO')
            ->orderBy('TOTAL_SELL_QTY', 'DESC');



            if($limit){
                $variant = $variant->take($limit)->get();
                $order_limit = $order_limit1 = $limit*5;
            }else{
                $variant = $variant->get();
                $order_limit = $order_limit1 = 5000;
            }

            if($variant){
                BestSellVariantDetail::where('F_SHOP_NO',$branch->PK_NO)->delete();
                DB::table('PRD_BEST_SELL_MASTER_DETAIL')->where('F_SHOP_NO',$branch->PK_NO)->delete();
                $best_sell                      = new BestSell();
                $best_sell->FROM_DATE           = $from_date;
                $best_sell->TO_DATE             = $to_date;
                $best_sell->MAX_VARIANT         = $limit;
                $best_sell->SS_CREATED_ON       = date('Y-m-d H:i:s');
                $best_sell->F_SS_CREATED_BY     = 1;
                $best_sell->HAS_CHILD           = 1;
                $best_sell->F_SHOP_NO           = $branch->PK_NO;
                $best_sell->SHOP_NAME           = $branch->SHOP_NAME;
                $best_sell->save();

                $id = $best_sell->PK_NO;
                foreach($variant as $key => $row){
                    // dd($row);
                    $child                          = new BestSellVariantDetail();
                    $child->F_BEST_SELL_MASTER_NO   = $id;
                    $child->F_PRD_MASTER_SETUP_NO   = $row->F_PRD_MASTER_SETUP_NO;
                    $child->F_PRD_VARIANT_NO        = $row->F_PRD_VARIANT_NO;
                    $child->VARIANT_NAME            = $row->PRD_VARINAT_NAME;
                    $child->QTY                     = $row->TOTAL_SELL_QTY;
                    $child->SELL_AMOUNT             = $row->TOTAL_SELL_AMOUNT;
                    $child->ORDER_ID                = $order_limit-5;
                    $child->F_SHOP_NO               = $branch->PK_NO;
                    $child->SHOP_NAME               = $branch->SHOP_NAME;
                    $child->save();
                    $order_limit = $order_limit - 5;
                }

                // dd($variant);
                $best_sell_master = BestSellVariantDetail::select('F_PRD_MASTER_SETUP_NO',DB::raw('SUM(QTY) as TOTAL_SELL_QTY'), DB::raw('SUM(SELL_AMOUNT) as TOTAL_SELL_AMOUNT'), DB::raw('COUNT(*) as TOTAL_SELL_VARIANT'))->where('F_BEST_SELL_MASTER_NO',$id)->where('F_SHOP_NO',$branch->PK_NO)->groupBy('F_PRD_MASTER_SETUP_NO')->orderBy('TOTAL_SELL_QTY', 'DESC')->get();

                if($best_sell_master){
                    $count_best_sell_master = $best_sell_master->count();
                    $order_limit2 = $count_best_sell_master*5;
                    foreach($best_sell_master as $k1 => $row1){
                        DB::table('PRD_BEST_SELL_MASTER_DETAIL')->insert([
                            'F_BEST_SELL_MASTER_NO' => $id,
                            'F_PRD_MASTER_SETUP_NO' => $row1->F_PRD_MASTER_SETUP_NO,
                            'QTY'                   => $row1->TOTAL_SELL_QTY,
                            'SELL_AMOUNT'           => $row1->TOTAL_SELL_AMOUNT,
                            'ORDER_ID'              => $order_limit2 - 5,
                            'QTY_MARK'              => $order_limit2 - 5,
                            'TOTAL_BEST_SELL_VARIANT' => $row1->TOTAL_SELL_VARIANT,
                            'F_SHOP_NO'               => $branch->PK_NO,
                            'SHOP_NAME'               => $branch->SHOP_NAME,
                        ]);
                        $order_limit2 = $order_limit2 - 5;
                    }

                    $best_sell_master = BestSellMasterDetail::where('F_BEST_SELL_MASTER_NO', $id)->where('F_SHOP_NO', $branch->PK_NO)->orderBy('SELL_AMOUNT', 'DESC')->get();
                    if($best_sell_master){
                        $order_limit2 = $count_best_sell_master*5;
                        foreach($best_sell_master as $k2 => $row2){
                            $ord    = $order_limit2-5;
                            $ord1   = $row2->QTY_MARK + $order_limit2-5;
                            BestSellMasterDetail::where('PK_NO',$row2->PK_NO)->update(['AMOUNT_MARK' => $ord, 'ORDER_ID' => $ord1 ]);
                            $order_limit2 = $order_limit2 - 5;
                        }
                    }

                }
            }

        } catch (\Exception $e) {
            dd( $e);
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.top_sell.list');
        }
            DB::commit();
        return $this->formatResponse(true, 'Successfully generated top sell report', 'admin.top_sell.list');


    }

    public function topSellDelete($request){
        DB::beginTransaction();
        try {
            $draft_decords_array = $request->draft;
            $master = BestSellMasterDetail::whereIn('PK_NO', $draft_decords_array)->get();
            if($master){
                foreach($master as $k => $row){
                    BestSellVariantDetail::where('F_BEST_SELL_MASTER_NO',$row->F_BEST_SELL_MASTER_NO)
                    ->where('F_PRD_MASTER_SETUP_NO',$row->F_PRD_MASTER_SETUP_NO)->delete();
                }
            }

            BestSellMasterDetail::whereIn('PK_NO', $draft_decords_array)->delete();

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.top_sell.list');
        }
            DB::commit();
        return $this->formatResponse(true, 'Top sell list deleted successfully !', 'admin.top_sell.list');
    }

    public function topSellVariantDelete($request){
        DB::beginTransaction();
        try {
            $draft_decords_array = $request->draft;
            $variants = BestSellVariantDetail::whereIn('PK_NO', $draft_decords_array)->get();
            BestSellVariantDetail::whereIn('PK_NO', $draft_decords_array)->delete();

            if($variants){
                foreach($variants as $key =>  $prod){
                    $total_varint =  BestSellVariantDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_BEST_SELL_MASTER_NO',$prod->F_BEST_SELL_MASTER_NO)->count();

                    BestSellMasterDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_BEST_SELL_MASTER_NO',$prod->F_BEST_SELL_MASTER_NO)->update(['TOTAL_BEST_SELL_VARIANT' => $total_varint]);

                }
            }



        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.top_sell.list');
        }
            DB::commit();
        return $this->formatResponse(true, 'Top sell list deleted successfully !', 'admin.top_sell.list');
    }

    public function topSellOrderidUpdate($request){
        DB::beginTransaction();
        try {
            BestSellMasterDetail::where('PK_NO', $request->pk_no)->update(['ORDER_ID' => $request->order_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.top_sell.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Top sell list order id updated successfully !', 'admin.top_sell.list');
    }

    public function topSellVariantOrderidUpdate($request){
        DB::beginTransaction();
        try {
            BestSellVariantDetail::where('PK_NO', $request->pk_no)->update(['ORDER_ID' => $request->order_id]);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.top_sell.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Top sell list order id updated successfully !', 'admin.top_sell.list');
    }


    public function postTopSellMasterStore($request){
            // branch_id
            // dd($request->all());
        DB::beginTransaction();
        try {

            if($request->product_id){
                foreach($request->product_id as $k => $item){
                    $bestsell   = BestSell::where('PK_NO',$request->top_sell_master)->first();
                    $child      = BestSellMasterDetail::where('F_PRD_MASTER_SETUP_NO',$item)
                                ->where('F_SHOP_NO',$bestsell->F_SHOP_NO)
                                ->first();
                    if($child == null){
                        $prod  = Product::find($item);
                        $max_order = BestSellMasterDetail::max('ORDER_ID')+5;
                        $child                          = new BestSellMasterDetail();
                        $child->F_BEST_SELL_MASTER_NO   = $request->top_sell_master;
                        $child->F_PRD_MASTER_SETUP_NO   = $prod->PK_NO;
                        $child->IS_MANUAL               = 1;
                        $child->QTY                     = 0;
                        $child->SELL_AMOUNT             = 0;
                        $child->SHOP_NAME               = $bestsell->SHOP_NAME;
                        $child->F_SHOP_NO               = $bestsell->F_SHOP_NO;
                        $child->ORDER_ID                = $max_order;
                        $child->save();
                        $prods = ProductVariant::select('PRD_VARIANT_SETUP.*')
                        ->where('PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO',$item)
                        ->leftJoin('PRD_SHOP_VARIANT_MAP', 'PRD_SHOP_VARIANT_MAP.F_PRD_VARIANT_NO','PRD_VARIANT_SETUP.PK_NO')
                        ->where('PRD_SHOP_VARIANT_MAP.F_SHOP_NO',$bestsell->F_SHOP_NO)
                        ->get();
                        // dd($prods);
                        // if($prods && count($prods)>0){
                            foreach ($prods as $key => $prod) {
                                $max_order  = BestSellVariantDetail::max('ORDER_ID')+5;
                                $veriant                          = new BestSellVariantDetail();
                                $veriant->F_BEST_SELL_MASTER_NO   = $request->top_sell_master;
                                $veriant->F_PRD_VARIANT_NO        = $prod->PK_NO;
                                $veriant->VARIANT_NAME            = $prod->VARIANT_NAME;
                                $veriant->IS_MANUAL               = 1;
                                $veriant->QTY                     = 0;
                                $veriant->SELL_AMOUNT             = 0;
                                $veriant->ORDER_ID                = $max_order;
                                $veriant->F_PRD_MASTER_SETUP_NO   = $prod->F_PRD_MASTER_SETUP_NO;
                                $veriant->F_SHOP_NO               = $bestsell->F_SHOP_NO;
                                $veriant->SHOP_NAME               = $bestsell->SHOP_NAME;
                                $veriant->save();
                                // dd($veriant);
                                $total_varint =  BestSellVariantDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_BEST_SELL_MASTER_NO',$request->top_sell_master)->count();
                                BestSellMasterDetail::where('F_PRD_MASTER_SETUP_NO',$item)->where('F_SHOP_NO',$bestsell->F_SHOP_NO)->update(['TOTAL_BEST_SELL_VARIANT' => $total_varint]);
                            }
                        // }
                    }
                }
            }
        } catch (\Exception $e) {

            echo '<pre>';
            echo '======================<br>';
            print_r($e->getMessage());
            echo '<br>======================';
            exit();

            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.top_sell.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product added to Top sell list successfully !', 'admin.top_sell.list');
    }

    public function postTopSellVaraitnStore($request){
        DB::beginTransaction();
        try {
            if($request->product_id){
                foreach($request->product_id as $k => $item){
                    $f_best_sell_master_no = $request->top_sell_master;
                    $best_sell = BestSell::find($f_best_sell_master_no);
                    $child = BestSellVariantDetail::where('F_PRD_VARIANT_NO',$item)->where('F_BEST_SELL_MASTER_NO',$f_best_sell_master_no)->first();
                    if($child == null){
                        $prod       = ProductVariant::find($item);
                        $max_order  = BestSellVariantDetail::max('ORDER_ID')+5;
                        $child                          = new BestSellVariantDetail();
                        $child->F_BEST_SELL_MASTER_NO   = $f_best_sell_master_no;
                        $child->F_PRD_VARIANT_NO            = $prod->PK_NO;
                        $child->VARIANT_NAME            = $prod->VARIANT_NAME;
                        $child->IS_MANUAL                = 1;
                        $child->QTY                     = 0;
                        $child->SELL_AMOUNT             = 0;
                        $child->ORDER_ID                = $max_order;
                        $child->F_PRD_MASTER_SETUP_NO   = $prod->F_PRD_MASTER_SETUP_NO;
                        $child->F_SHOP_NO               = $best_sell->F_SHOP_NO;
                        $child->SHOP_NAME               = $best_sell->SHOP_NAME;
                        $child->save();

                        $total_varint =  BestSellVariantDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_BEST_SELL_MASTER_NO',$f_best_sell_master_no)->where('F_SHOP_NO',$best_sell->F_SHOP_NO)->count();

                        BestSellMasterDetail::where('F_PRD_MASTER_SETUP_NO',$prod->F_PRD_MASTER_SETUP_NO)->where('F_SHOP_NO',$best_sell->F_SHOP_NO)->where('F_BEST_SELL_MASTER_NO',$f_best_sell_master_no)->update(['TOTAL_BEST_SELL_VARIANT' => $total_varint]);

                    }

                }
            }

        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'admin.top_sell.list');
        }
        DB::commit();
        return $this->formatResponse(true, 'Product added to Top sell list successfully !', 'admin.top_sell.list');
    }

    public function getTopSellVariant($request,$id){

        try {
        $top_sell_master    = BestSellMasterDetail::find($id);
        $master_no  = $top_sell_master->F_PRD_MASTER_SETUP_NO;
        $prd_master = Product::find($master_no);
        $f_best_sell_master_no  = $top_sell_master->F_BEST_SELL_MASTER_NO;
        $all_variant        = ProductVariant::select('PRD_BEST_SELL_VARIANT_DETAIL.*','PRD_VARIANT_SETUP.PK_NO as PRD_VARIANT_NO','PRD_VARIANT_SETUP.VARIANT_NAME')
        ->where('PRD_VARIANT_SETUP.F_PRD_MASTER_SETUP_NO',$top_sell_master->F_PRD_MASTER_SETUP_NO)
        ->leftJoin('PRD_BEST_SELL_VARIANT_DETAIL', function($join) use ($master_no,$f_best_sell_master_no){
            $join->on('PRD_VARIANT_SETUP.PK_NO', '=', 'PRD_BEST_SELL_VARIANT_DETAIL.F_PRD_VARIANT_NO');
            $join->on('PRD_BEST_SELL_VARIANT_DETAIL.F_PRD_MASTER_SETUP_NO','=',DB::raw($master_no));
            $join->on('PRD_BEST_SELL_VARIANT_DETAIL.F_BEST_SELL_MASTER_NO','=',DB::raw($f_best_sell_master_no));

        })
        ->where('PRD_VARIANT_SETUP.IS_ACTIVE',1)
        ->orderBy('PRD_BEST_SELL_VARIANT_DETAIL.ORDER_ID','DESC')
        ->get();
        $data['top_sell_master'] = $top_sell_master;
        $data['prd_master'] = $prd_master;
        $data['all_variant'] = $all_variant;
    } catch (\Exception $e) {
        return $this->formatResponse(false, $e->getMessage(), 'admin.top_sell.list');
    }
    return $this->formatResponse(true, 'Top sell Variant list', 'admin.top_sell.list', $data);

        // $top_sell_variant = BestSellVariantDetail::where('F_PRD_MASTER_SETUP_NO',$top_sell_master->F_PRD_MASTER_SETUP_NO)
        // ->where('F_BEST_SELL_MASTER_NO',$top_sell_master->F_BEST_SELL_MASTER_NO)->get();


    }



}

