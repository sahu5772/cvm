<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MailService
{
    public function handle($request, Closure $next)
    {
      $app = App::getInstance();
      $app->register('App\Providers\MailServiceProvider');
      return $next($request);
    }
}
