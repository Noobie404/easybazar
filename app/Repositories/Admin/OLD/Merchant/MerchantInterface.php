<?php

namespace App\Repositories\Admin\Merchant;

interface MerchantInterface
{
    public function getPaginatedList($request);
    public function postStore($request);
    public function postUpdate($request, int $id);
    // public function delete($id);
}
