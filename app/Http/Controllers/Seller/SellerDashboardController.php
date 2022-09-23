<?php

namespace App\Http\Controllers\Seller;

use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class SellerDashboardController extends Controller
{
    protected $auth;

    public function __construct()
    {
        // $this->auth = $auth;
    }

    public function getIndex(Request $request){
        // dd(1);
        return view('seller.dashboard.home');
    }
}
