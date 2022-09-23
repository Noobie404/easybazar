<?php

namespace App\Repositories\Admin\InvoiceDetails;

interface InvoiceDetailsInterface
{
    public function getPaginatedList($request, int $per_page = 20, $id);
    public function getProductBySubCategory($id);
    public function getInvoiceData($id,$request);
    public function getVariantListById($data);
    public function getVariantListByBarCode($request,$bar_code,$type);
    public function postStore($request);
    public function getVariantListByQueryString($request, $queryString);
    /*public function postUpdate($request, int $id);
    public function findOrThrowException($id);*/
    public function delete($id, $request);
    public function getProductByInvoice($request, $id,$type);
}
