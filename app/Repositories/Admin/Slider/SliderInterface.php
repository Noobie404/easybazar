<?php

namespace App\Repositories\Admin\Slider;

interface SliderInterface
{
    public function getPaginatedList($request, int $per_page = 5);
    public function getCustomLinks($request);
    public function postStore($request);
    public function postCustomLinkStore($request);
    public function postUpdate($request, int $id);
    public function postCustomLinkUpdate($request, int $id);
    public function updateSliderPhotos($request, int $id);
    public function postAddPhotos($request);



    public function getShow(int $id);

    //public function findOrThrowException($id);
    public function delete($id);
    public function getCustomLinkDelete($id);
    public function getDeleteSlider($id);
    public function getOrderUp($id);
    public function getOrderDown($id);
    // public function getDeleteImage($id);



}
