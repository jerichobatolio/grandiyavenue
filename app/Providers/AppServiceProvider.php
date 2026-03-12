<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // When hosting: if APP_URL is still localhost but the user visits via another host
        // (e.g. your real domain), use the request URL for assets and storage so images and
        // assets load correctly.
        if (!$this->app->runningInConsole() && request()->hasHeader('Host')) {
            $host = parse_url(config('app.url') ?: '', PHP_URL_HOST);
            $isLocalhost = in_array($host, ['localhost', '127.0.0.1'], true);
            if ($isLocalhost && request()->getHost() !== $host) {
                URL::forceRootUrl(request()->getSchemeAndHttpHost());
            }
        }
    }
}
