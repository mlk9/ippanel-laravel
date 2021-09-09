# IPPanel Laravel
This package makes it easy to send SMS notification using IPPanel API with Laravel.
# Installation
You can install the package via composer:
```sh
composer require mlk9/ippanel-laravel
```
# Setting up your IPPanel
```sh
// config/services.php
'ippanel' => [
        'token' => env('IPPANEL_TOKEN', 'YOUR IPPANEL TOKEN HERE'),
        'originator' => env('IPPANEL_ORIGINATOR', 'YOUR IPPANEL ORIGINATOR HERE'),
],
```
# Usage
```sh
class ExampleNotification extends Notification
{
    
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['sms'];
    }

    public function toSms($notifiable)
    {
        return [
            'type' => 'patternMessage',
            'code' => config('services.sms.res_ticket'),
            'values' => ['name'=>$notifiable->name],
            'recipient'=>  $notifiable->phone,
        ];
    }

}


```
