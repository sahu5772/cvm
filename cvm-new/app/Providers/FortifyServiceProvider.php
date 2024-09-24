<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
            elseif($user)
            {
                if($user->login_attempt > 3)
                {
                    // send mail
                }
                else
                {
                    $user->login_attempt = $user->login_attempt + 1;
                    $user->update();
                }
                Artisan::call('cache:clear');
                Artisan::call('route:clear');
            }

        });

        Fortify::registerView(function () {
            return view('auth.register');
        });
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });

    }
}
