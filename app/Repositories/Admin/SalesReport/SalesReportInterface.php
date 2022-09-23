<?php

namespace App\Repositories\Admin\SalesReport;

interface SalesReportInterface
{
    public function getComissionReport($id);
    public function getYetToShip($request);
    public function topSell($request);
    public function getTopSellVariant($request,$id);
    public function topSellCreate($request);
    public function topSellDelete($request);
    public function topSellVariantDelete($request);
    public function topSellOrderidUpdate($request);
    public function topSellVariantOrderidUpdate($request);
    public function postTopSellMasterStore($request);
    public function postTopSellVaraitnStore($request);
    public function ajaxComissionReport($agent_id,$date);
}
