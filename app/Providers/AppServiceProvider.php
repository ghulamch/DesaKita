<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Don't run DB queries if .env is missing or app is not installed yet
        if (!file_exists(base_path('.env')) || !file_exists(storage_path('installed'))) {
            return;
        }

        // Dynamic Mail Configuration from SiteMeta
        if (\Illuminate\Support\Facades\Schema::hasTable('site_metas')) {
            $mailConfig = [
                'transport' => 'smtp',
                'host' => \App\Models\SiteMeta::getVal('mail_host', config('mail.mailers.smtp.host')),
                'port' => \App\Models\SiteMeta::getVal('mail_port', config('mail.mailers.smtp.port')),
                'encryption' => \App\Models\SiteMeta::getVal('mail_encryption', config('mail.mailers.smtp.encryption')),
                'username' => \App\Models\SiteMeta::getVal('mail_username', config('mail.mailers.smtp.username')),
                'password' => \App\Models\SiteMeta::getVal('mail_password', config('mail.mailers.smtp.password')),
                'timeout' => null,
                'local_domain' => env('MAIL_EHLO_DOMAIN'),
            ];

            config(['mail.mailers.smtp' => $mailConfig]);
            
            $fromAddress = \App\Models\SiteMeta::getVal('mail_from_address');
            $fromName = \App\Models\SiteMeta::getVal('mail_from_name', \App\Models\SiteMeta::getVal('village_name', 'Portal Desa'));

            if ($fromAddress) {
                config(['mail.from.address' => $fromAddress]);
                config(['mail.from.name' => $fromName]);
            }
        }
        // Global View Composer to share village meta with all views
        \Illuminate\Support\Facades\View::composer(['admin.*', 'resident.*', 'layouts.admin'], function ($view) {
            $villageName = \App\Models\SiteMeta::getVal('village_name', 'Digital Sejahtera');
            $villageTerm = \App\Models\SiteMeta::getVal('village_term', 'Desa');
            if($villageTerm === 'Lainnya') {
                $villageTerm = \App\Models\SiteMeta::getVal('village_term_custom', 'Desa');
            }
            $view->with('villageName', $villageName);
            $view->with('villageTerm', $villageTerm);
        });
        // Use Tailwind for pagination
        \Illuminate\Pagination\Paginator::useTailwind();
    }
}
