<?php

namespace Mlk9\Sms;

use Illuminate\Support\ServiceProvider;
use Mlk9\Sms\SmsChannel;
use Mlk9\Sms\Sms;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Mlk9\Sms\Facades\Sms as FacadesSms;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/ippanel.php', 'ippanel');
        $this->app->singleton(FacadesSms::class, Sms::class);
    }
    /**
     * Boot any application services.
     *
     * @return void
     */
    public function boot()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('sms', function ($app) {
                return new SmsChannel();
            });
        });
    }

    /**
     * Setting publishing for the package.
     *
     * @return void
     */
    protected function settingPublishing() : void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/ippanel.php' => config_path('ippanel.php'),
        ], 'ippanel-laravel');
    }

}
