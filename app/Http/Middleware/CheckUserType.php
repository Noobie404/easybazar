<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Redirect;
use App\Services\Access;
use Auth;

class CheckUserType
{
    public function handle($request, Closure $next)
    {
        // $access = new Access();

        if (Auth::guard('seller')->check()) { //Default guard
            return $next($request);
        }elseif (Auth::check()) {
            return $next($request);
        }

        echo '<pre>';
        echo '======================<br>';
        print_r('middleware '.Auth::user());
        echo '<br>======================<br>';
        exit();
        // return redirect()->back()->with('flashMessageAlert','You do not have the permission to access the page !');
        return redirect()->route('login');
    }
}
