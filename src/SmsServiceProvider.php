<?php

namespace Mlk9\Sms;

use Illuminate\Support\ServiceProvider;
use Mlk9\Sms\SmsChannel;
use Mlk9\Sms\Sms;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(SmsChannel::class)
            ->needs(Sms::class)
            ->give(static function () {
                return new Sms(
                    config('services.ippanel.api'),
                    config('services.ippanel.originator'),
                );
            });
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
                return new SmsChannel(new Sms(
                    config('services.ippanel.api'),
                    config('services.ippanel.originator'),
                ));
            });
        });
    
    }

}