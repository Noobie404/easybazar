<?php
namespace App\Repositories\Admin\DeliveryBoy;
use DB;
use Image;
use App\User;
use App\Models\Area;
use App\Models\City;
use App\Models\State;
use App\Models\Seller;
use App\Models\AreaMap;
use App\Models\Country;
use App\Models\DeliveryBoy;
use App\Traits\ApiResponse;
use App\Traits\RepoResponse;
use App\Models\PaymentBankAcc;
use App\Models\DeliveryBoyArea;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DeliveryBoyAbstract implements DeliveryBoyInterface
{
    use RepoResponse;
    use ApiResponse;
    public function __construct(DeliveryBoy $deliveryBoy)
    {
        $this->deliveryBoy = $deliveryBoy;
    }

    public function getPaginatedList($request, int $per_page = 5)
    {
        $data = User::where('USER_TYPE',20)->orderBy('NAME', 'ASC')->get();
        foreach ($data as $key => $value) {
            $value->area = DB::table('SS_DELIVERYBOY_AREA_COVERAGE')->where('F_USER_NO',$value->PK_NO)->get();
        }

        return $this->formatResponse(true, '', 'admin.delivery_boy.index', $data);
    }

    public function getShow(int $id)
    {
        $data =  DeliveryBoy::find($id);
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.customer-address.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.customer.view', null);
    }

    public function getView($id)
    {
        $data = User::where('PK_NO',$id)->first();

        // dd($data);

        // ->select('SLS_DELIVERY_BOY.*','SS_AREA.AREA_NAME','SS_CITY.CITY_NAME','SS_STATE.STATE_NAME')
        // ->leftJoin('SS_AREA','SLS_DELIVERY_BOY.F_AREA_NO','SS_AREA.PK_NO')
        // ->leftJoin('SS_CITY','SLS_DELIVERY_BOY.F_CITY_NO','SS_CITY.PK_NO')
        // ->leftJoin('SS_STATE','SLS_DELIVERY_BOY.F_STATE_NO','SS_STATE.PK_NO')
        // ->first();

        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'admin.customer-address.edit', $data);
        }

        return $this->formatResponse(false, 'Did not found data !', 'admin.customer.view', null);
    }


    public function postStore($request)
    {

        DB::beginTransaction();
        try {
            // $checkExist = DeliveryBoy::where('EMAIL',$request->email)->first();
            // if($checkExist){
            //     return $this->successResponse(200, 'This email address is already being used!', '', 0);
            // }
            // dd($request->all());
            $delivery                   = new User();
            $delivery->NAME             = $request->name;
            $delivery->MOBILE_NO        = $request->mobile_no;
            $delivery->EMAIL            = $request->email;
            $delivery->PASSWORD         = Hash::make($request->password);
            $delivery->ADDRESS          = $request->address;
            $delivery->MONTHLY_SALARY       = $request->sallery;
            $delivery->PER_DELIVERY_COMM    = $request->per_delivery_comm;
            $delivery->USER_TYPE            = 20;
            $delivery->JOINING_DATE         = date('Y-m-d',strtotime($request->joining_date));
            $delivery->IS_ACTIVE       = $request->is_active ?? 1;
            if(!is_null($request->file('photo'))){
                $path      = 'public/media/images/delivery_boy';
                $image      = $request->file('photo');
                $img        = Image::make($image->getRealPath());
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $base_name  = preg_replace('/\..+$/', '', $image->getClientOriginalName());
                $base_name  = explode(' ', $base_name);
                $base_name  = implode('-', $base_name);
                $image_name = $base_name."-".uniqid().'.webp';
                Image::make($img)->save($path.'/'.$image_name);
                $photo = '/'.$path .'/'. $image_name;
                $delivery->PROFILE_PIC_URL = url($photo);
            }
            $delivery->save();

            //create cod account
            $account                  = new PaymentBankAcc();
            $account->BANK_NAME       = 'COD';
            $account->BRANCH_NAME     = 'COD-EASYBAZAR';
            $account->BANK_ACC_NAME   = 'COD-'.$request->name;
            $account->BANK_ACC_NO     = 'COD'.$delivery->PK_NO;
            $account->IS_COD          = 1;
            $account->F_USER_NO       = $delivery->PK_NO;
            $account->START_DATE      = date('Y-m-d');
            $account->IS_ACTIVE       = 1;
            $account->save();

            $data = view('admin.delivery_boy.view')->withRow($delivery)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'delivery boy not saved !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'delivery boy sucessfully save!', $data, 1);
    }

    public function postUpdate($request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $delivery                = User::findOrFail($request->id);
            $delivery->NAME          = $request->name;
            $delivery->MOBILE_NO     = $request->mobile_no;
            $delivery->EMAIL         = $request->email;
            if($request->password){
                $delivery->PASSWORD      = Hash::make($request->password);
            }
            $delivery->ADDRESS      = $request->address;
            $delivery->MONTHLY_SALARY = $request->sallery;
            $delivery->IS_ACTIVE = $request->is_active;

            $delivery->PER_DELIVERY_COMM    = $request->per_delivery_comm;
            $delivery->JOINING_DATE         = date('Y-m-d',strtotime($request->joining_date));

            if(!is_null($request->file('photo'))){
                if (File::exists(public_path($delivery->PROFILE_PIC_URL))) {
                    File::delete(public_path($delivery->PROFILE_PIC_URL));
                }
                $path      = 'public/media/images/delivery_body';
                $image      = $request->file('photo');
                $img        = Image::make($image->getRealPath());
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $base_name  = preg_replace('/\..+$/', '', $image->getClientOriginalName());
                $base_name  = explode(' ', $base_name);
                $base_name  = implode('-', $base_name);
                $image_name = $base_name."-".uniqid().'.webp';
                Image::make($img)->save($path.'/'.$image_name);
                $photo = '/'.$path .'/'. $image_name;
                $delivery->PROFILE_PIC_URL = url($photo);
            }
            $delivery->update();
            $data['delivery_boy'] =$delivery;
            $data['html'] = view('admin.delivery_boy.view')->withRow($delivery)->render();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'delivery boy not updated !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'delivery boy sucessfully updated!', $data, 1);
    }

    public function getDelete($PK_NO)
    {
        DB::beginTransaction();
        try {
            $delivery = DeliveryBoy::where('PK_NO',$PK_NO)->first();
            $delivery->IS_ACTIVE = 0;
            $delivery->update();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            return $this->successResponse($e->getCode(), 'delivery boy not updated !', '', 0);
        }
            DB::commit();
            return $this->successResponse(200, 'delivery boy sucessfully updated!', $delivery, 1);
    }

    public function getDeliveryList($request){
        $data = DeliveryBoy::where('PK_NO',$request->dboy_id)->first();
        if (!empty($data)) {
        return $this->formatResponse(true, 'Data found', 'admin.delivery_boy.delivery_list', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.delivery_boy.delivery_list', null);
    }

    public function getCoverageArea($request,$id){

        DB::beginTransaction();
        try {
            $data['user']   = User::find($id);
            $data['user']->area = DB::table('SS_DELIVERYBOY_AREA_COVERAGE')->where('F_USER_NO',$data['user']->PK_NO)->get();
            $data['countryCombo']   = Country::pluck('NAME', 'PK_NO');
            $data['stateCombo']     = State::where('IS_ACTIVE',1)->pluck('STATE_NAME', 'PK_NO');
            $data = view('admin.delivery_boy.coverage_area.create')->withData($data)->render();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
        }
        DB::commit();
        return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
    }


    public function postCoverageArea($request,$id)
    {
        $data = [];
        $auth_id = Auth::id();
        DB::beginTransaction();
            try {
                $state  = State::find($request->region);
                $city   = City::find($request->city);
                $area   = Area::find($request->area);
                $user  = User::find($request->id);
                if (!empty($request->subarea))
                {
                    $area_id = array();
                    foreach ($request->subarea as $value)
                    {
                        $area_id[] = $value;
                    }
                    $area_id = array_unique($area_id);

                    $data = array();
                    foreach ($area_id as $key => $value)
                    {
                        $sub_area = AreaMap::find($value);
                        $checkDuplicate = DeliveryBoyArea::where('F_SUB_AREA_NO',$value)->where('F_USER_NO',$request->id)->first();
                        // $checkExist = DeliveryBoyArea::where('F_SUB_AREA_NO',$value)->where('F_USER_NO','!=',$request->id)->first();
                        // if($checkExist){
                        //     return $this->successResponse(200, 'This area already assigned other shop !', '', 0);
                        // }
                        if(is_null($checkDuplicate)){
                        array_push($data, [
                            'F_COUNTRY_NO'      => 1,
                            'F_STATE_NO'        => $request->region,
                            'STATE_NAME'        => $state->STATE_NAME,
                            'F_CITY_NO'         => $request->city,
                            'CITY_NAME'         => $city->CITY_NAME,
                            'F_AREA_NO'         => $request->area,
                            'AREA_NAME'         => $area->AREA_NAME,
                            'F_SUB_AREA_NO'     => $value,
                            'SUB_AREA_NAME'     => $sub_area->SUB_AREA_NAME,
                            'F_USER_NO'         => $user->PK_NO,
                            'USER_NAME'         => $user->NAME ?? NULL,
                            'F_SS_CREATED_BY'   => Auth::id(),
                            'F_SS_MODIFIED_BY'  => NULL,
                            'SS_MODIFIED_ON'    => NULL,
                            'SS_CREATED_ON'     => date('Y-m-d H:i:s'),
                            ]
                        );
                        }
                    }
                    DB::table('SS_DELIVERYBOY_AREA_COVERAGE')->insert($data);
                }

            } catch (\Exception $e) {
                dd($e->getMessage());
                DB::rollback();
                return $this->successResponse($e->getCode(), 'Area not saved !', '', 0);
            }
                DB::commit();
            return $this->successResponse(200, 'Area sucessfully save!', $data, 1);
     }



}
