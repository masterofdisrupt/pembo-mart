<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Backend\V1\SMTPModel;
use Config;

class AppServiceProvider extends ServiceProvider
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
    public function boot(): void
    {
        Paginator::useBootstrap();

        $mailsetting = SMTPModel::find(1);

        if ($mailsetting) {
            $data = [
                'driver' => $mailsetting->mail_mailer,
                'host' => $mailsetting->mail_host,
                'port' => $mailsetting->mail_port,
                'encryption' => $mailsetting->mail_encryption,
                'username' => $mailsetting->mail_username,
                'password' => $mailsetting->mail_password,
                'from' => [
                    'address' => $mailsetting->mail_from_address,
                    'name' => $mailsetting->app_name
                ]
            ];
            $AppName = [
                'name' => $mailsetting->app_name
            ];

            Config::set('app.name', $AppName['name']);

            Config::set('mail', $data);
        }

    }
}
