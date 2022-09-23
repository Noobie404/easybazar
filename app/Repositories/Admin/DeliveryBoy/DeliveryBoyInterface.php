<?php

namespace App\Repositories\Admin\DeliveryBoy;

interface DeliveryBoyInterface
{
    public function getPaginatedList($request, int $per_page = 20);
    public function postStore($request);
    public function postUpdate($request);
    public function getShow(int $id);
    public function getDelete($id);
    public function getView($id);
    public function getDeliveryList($request);
    public function getCoverageArea($request,$id);
    public function postCoverageArea($request,$id);



}
