<?php

namespace App\Repositories\Admin\Stock;

interface StockInterface
{
    public function getAllStockList($request);
    public function getStockDetail($request);

}
