<?php

namespace App\Providers;

use App\Models\EmailSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
         $mailSetting = EmailSetting::configuredEmail()->first();
        if($mailSetting){
            $data = [
                'driver'            => 'smtp',
                'host'              => $mailSetting->mail_host,
                'port'              => $mailSetting->mail_port,
                // 'encryption'        => $mailSetting->mail_encryption,
                'username'          => $mailSetting->mail_username,
                'password'          => $mailSetting->mail_password,
                'from'       => array('address' => $mailSetting->mail_from_email, 'name' => $mailSetting->mail_from_name),
            ];
            Config::set('mail',$data);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
