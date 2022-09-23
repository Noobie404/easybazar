<?php

namespace App\Repositories\Admin\Page;

interface PageInterface
{
    public function getHomeSetting($request);
    public function postSettingUpdate($request);
    public function sliderUpdate($request);





}
