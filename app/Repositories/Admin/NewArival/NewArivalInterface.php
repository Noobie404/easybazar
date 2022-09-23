<?php

namespace App\Repositories\Admin\NewArival;

interface NewArivalInterface
{

    // public function getTopSellVariant($request,$id);
    public function newArivalCreate($request);
    public function newArivalDelete($request);
    public function newArivalVariantDelete($request);
    public function newArivalOrderidUpdate($request);
    public function newArivalVariantOrderidUpdate($request);
    public function postNewArivalMasterStore($request);
    public function postNewArivalVaraitnStore($request);

}
