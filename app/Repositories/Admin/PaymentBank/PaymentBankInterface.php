<?php

namespace App\Repositories\Admin\PaymentBank;

interface PaymentBankInterface
{
    public function getPaginatedList($request, int $per_page = 5);
    public function postStore($request);
    public function postEdit($request, int $id);
   // public function delete($id);
//    public function getTransaction($id);
}
