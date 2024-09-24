<?php

namespace App\Http\Controllers;

use App\Models\CompanyLogo;
use App\Models\Notification;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {

        $this->middleware(function ($request, $next) {
            if (auth()->check()) {
                View::share('logo', User::where('id',Auth::user()->id)->pluck('profile_picture')->first());
            }
            return $next($request);
        });
    }


}
