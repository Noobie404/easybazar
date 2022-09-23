<?php
namespace App\Models\Web;
use Illuminate\Support\Str;
use App\Traits\RepoResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
class WhatsApp extends Model
{
    use RepoResponse;
    protected $table        = 'WEB_WHATSAPP';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    public function getPaginatedList($request, int $per_page = 2000)
    {
        $data = $this->orderBy('ORDER_BY','DESC')->get();
        return $this->formatResponse(true, '', 'web.whatsapp', $data);
    }
    public function getShow(int $id)
    {
        $data =  Article::find($id);
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'web.whatsapp', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'admin.article.list', null);
    }


    public function getOrderUp($id)
    {
      DB::begintransaction();

        try {
      $whatsapp     = DB::table('WEB_WHATSAPP')->select('ORDER_BY')->where('PK_NO', $id)->first();

      $maxOrderId   = DB::table('WEB_WHATSAPP')->max('ORDER_BY');

      if($whatsapp->ORDER_BY >= $maxOrderId)
      {
        return $this->formatResponse(true, 'WhatsApp Order Updated !', 'web.whatsapp');
      }
      else
      {
        $this->updateWhatsAppOrderId($whatsapp->ORDER_BY + 1, 1);
        DB::table('WEB_WHATSAPP')->where('PK_NO', $id)->update(['ORDER_BY'=> $whatsapp->ORDER_BY + 1]);
      }
    } catch (\Exception $e) {
        DB::rollback();
        return $this->formatResponse(false, 'Unable to Update WhatsApp Order!', 'web.whatsapp');
    }
    DB::commit();
    return $this->formatResponse(true, 'WhatsApp Order Updated !', 'web.whatsapp');
    }

    public function getOrderDown($id)
    {
        DB::begintransaction();
        try {
        $whatsapp = DB::table('WEB_WHATSAPP')->select('ORDER_BY')->where('PK_NO', $id)->first();
      if($whatsapp->ORDER_BY != 1)
      {
        $this->updateWhatsAppOrderId($whatsapp->ORDER_BY - 1, 0);
        DB::table('WEB_WHATSAPP')->where('PK_NO', $id)->update(['ORDER_BY'=> $whatsapp->ORDER_BY - 1]);
      }
    } catch (\Exception $e) {
        DB::rollback();
        return $this->formatResponse(false, 'Unable to Update WhatsApp Order!', 'web.whatsapp');
    }
    DB::commit();
    return $this->formatResponse(true, 'WhatsApp Order Updated !', 'web.whatsapp');
    }

    public function updateWhatsAppOrderId($orderId, $orderType)
    {
        $whatsapp = DB::table('WEB_WHATSAPP')->select('ORDER_BY')->where('ORDER_BY', $orderId)->first();
      if(!empty($whatsapp))
      {
        if($orderType)
        {
            DB::table('WEB_WHATSAPP')->where('ORDER_BY', $orderId)->update(['ORDER_BY'=>$orderId - 1]);
        }
        else
        {
            DB::table('WEB_WHATSAPP')->where('ORDER_BY', $orderId)->update(['ORDER_BY'=>$orderId + 1]);
        }
      }
      return true;
    }


    public function getWhatsApp(int $id)
    {
        $data =  WhatsApp::find($id);
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'web.whatsapp', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'web.whatsapp', null);
    }

    public function getDelete($id)
    {
        DB::begintransaction();
        try {
           $whatsapp = WhatsApp::find($id);
            $whatsapp->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete this WhatsApp !', 'web.whatsapp');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete this WhatsApp !', 'web.whatsapp');
    }

    public function postStore($request)
    {


        DB::beginTransaction();
        try {
            $whatsapp                  = new WhatsApp();
            $whatsapp->NAME            = $request->name;
            $whatsapp->PHONE_NUMBER    = $request->phone;
            $whatsapp->DEFAULT_MSG    = $request->default_msg;
            $whatsapp->DESIGNATION    = $request->designation;
            if ($request->hasFile('photo'))
            {
                $whatsapp->PHOTO  = $this->uploadImage($request->photo);
            }
            $whatsapp->IS_ACTIVE       = $request->is_active ?? 1;
            $whatsapp->CREATED_BY      = Auth::user()->PK_NO;
            $whatsapp->ORDER_BY        = WhatsApp::max('ORDER_BY')+1;
            $whatsapp->CREATED_ON      = date("Y-m-d h:i:s", time());
            $whatsapp->save();
        } catch (\Exception $e) {
              DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'web.whatsapp');
        }
        DB::commit();
        return $this->formatResponse(true, 'WhatsApp has been created successfully !', 'web.whatsapp');
    }

    public function postUpdate($request)
    {
        DB::beginTransaction();
        try {
            $whatsapp                  = WhatsApp::find($request->id);
            $whatsapp->NAME            = $request->name;
            $whatsapp->PHONE_NUMBER    = $request->phone;
            $whatsapp->DEFAULT_MSG    = $request->default_msg;
            $whatsapp->DESIGNATION    = $request->designation;
            if ($request->hasFile('photo'))
            {
                $whatsapp->PHOTO  = $this->uploadImage($request->photo);
            }
            $whatsapp->IS_ACTIVE       = $request->is_active ?? 1;
            $whatsapp->MODIFIED_BY     = Auth::user()->PK_NO;
            $whatsapp->MODIFIED_ON     = date("Y-m-d h:i:s", time());
            $whatsapp->update();
        } catch (\Exception $e) {
              DB::rollback();
            return $this->formatResponse(false, $e->getMessage(), 'web.whatsapp');
        }
        DB::commit();

        return $this->formatResponse(true, 'WhatsApp has been created successfully !', 'web.whatsapp');
    }


    public function uploadImage($image)
    {
        if (!is_null($image))
        {
        $image = $image;
        $extension = $image->getClientOriginalExtension();
        $path = 'media/images/profile';
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $base_name = preg_replace('/\..+$/', '', $image->getClientOriginalName());
        $base_name = explode(' ', $base_name);
        $base_name = implode('-', $base_name);
        $img = Image::make($image->getRealPath());
        $image = $base_name . "-" . uniqid().'.webp';
        Image::make($img)->save($path.'/'.$image);
        $image_name = '/'.$path .'/'. $image;
            return $image_name;
        }
    }



}
