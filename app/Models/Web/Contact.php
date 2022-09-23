<?php
namespace App\Models\Web;
use App\Traits\RepoResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
class Contact extends Model
{
    use RepoResponse;
    protected $table        = 'WEB_CONTACT_MESSAGE';
    protected $primaryKey   = 'PK_NO';
    public $timestamps      = false;
    const CREATED_AT        = 'SS_CREATED_ON';
    const UPDATED_AT        = 'SS_MODIFIED_ON';

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
           $user = Auth::user();
           $model->F_SS_CREATED_BY = $user->PK_NO;
        });

        static::updating(function($model)
        {
           $user = Auth::user();
           $model->F_SS_MODIFIED_BY = $user->PK_NO;
        });
    }
    public function getPaginatedList($request, int $per_page = 1000)
    {
        $data = $this->where('IS_ACTIVE',1)->orderBy('PK_NO','DESC')->paginate($per_page);
        return $this->formatResponse(true, '', 'web.subscriber', $data);
    }
    public function getShow(int $id)
    {
        $data =  Subscribe::find($id);
        if (!empty($data)) {
            return $this->formatResponse(true, 'Data found', 'web.subscriber.edit', $data);
        }
        return $this->formatResponse(false, 'Did not found data !', 'web.subscriber', null);
    }

    public function postStore($request)
    {
        DB::beginTransaction();
        try {

        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create subscriber !', 'web.subscriber.create');
        }
        DB::commit();
        return $this->formatResponse(true, 'subscriber has been created successfully !', 'web.subscriber','');
    }

     public function postUpdate($request)
    {
        DB::beginTransaction();
        try {
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return $this->formatResponse(false, 'Unable to create article !', 'web.faq.edit',$request->id);
        }
        DB::commit();
        return $this->formatResponse(true, 'article has been created successfully !', 'web.faq',$faq->PK_NO);
    }

    public function getDelete(int $id)
    {
        DB::begintransaction();
        try {
            $faq = Subscribe::find($id)->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->formatResponse(false, 'Unable to delete product !', 'web.subscriber');
        }
        DB::commit();
        return $this->formatResponse(true, 'Successfully delete Article !', 'web.subscriber');
    }

}
