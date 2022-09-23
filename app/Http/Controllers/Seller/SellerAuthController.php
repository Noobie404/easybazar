<?php

namespace App\Http\Controllers\Seller;

use DB;
use Auth;
use Session;
use App\User;
use App\Http\Requests;
use App\Models\Seller;
use App\Models\AuthLog;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Seller\SellerLoginRequest;

class SellerAuthController extends Controller
{

/*
|--------------------------------------------------------------------------
| Login Controller
|--------------------------------------------------------------------------
|
| This controller handles authenticating users for the application and
| redirecting them to your home screen. The controller uses a trait
| to conveniently provide its functionality to your applications.
|
*/



 /**
     * the model instance
     * @var User
     */
    protected $user;
    /**
     * The Guard implementation.
     *
     * @var Authenticator
     */
    protected $auth;
    protected $authLog;


    /**
     * Create a new authentication controller instance.
     *
     * @param  Authenticator  $auth
     * @return void
     */

    public function __construct( Guard $auth )
    {
       // $this->middleware('guest:admin,seller')->except('logout');


        session(['url.intended' => url()->previous()]);
        $this->redirectTo = session()->get('url.intended');
        $this->middleware('guest')->except('logout');

        $this->auth = $auth;

    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
      public function getLogin()
      {

        return view('seller.auth.login');
        //   if (! $this->auth->check()) {

        //   } else {
        //       return redirect('admin');
        //   }
      }

    public function postLogin(SellerLoginRequest $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = \App\Models\Seller::where(['EMAIL' => $email])->where(function ($query) {
            $query->where('IS_ACTIVE', 1);
        })->first();
        if ($this->hasExist($user)) {
            if ($user->CAN_LOGIN == 0) {
                return redirect()->back()->withInput()->withErrors([
                    'EMAIL' => 'Your account is deactivated !',
                ]);
            }
            $remember_me = true;
            Session::flush();
            $this->auth->logout();

            Auth::shouldUse('seller');
            $user = Auth::attempt([
                'EMAIL'          => $email,
                'password'       => $password
            ]);
            // dd($user);
            // dd(Auth::user());

            if($user)
            {
                return redirect()->route('seller.dashboard');
            }
        }
        return redirect()->back()->withInput()->withErrors([
            'EMAIL' => 'The credentials you entered did not match our records. Try again?',
        ]);
    }

    private function hasExist($user_array){
        if (! empty($user_array )) return true;
        return false;
    }
}
