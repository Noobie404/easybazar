<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
class InventoryController extends BaseController
{
    protected $userGroup;

    public function __construct()
    {
    }

    public function getIndex(Request $request)
    {
        return view('admin.inventory.index');
    }

    public function getCreate() {

        return view('admin.inventory.create');
    }





}
