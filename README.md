# IPPanel Laravel

This package makes it easy to send SMS notification using IPPanel API with Laravel.

# Requirement

- Laravel 6+

# Features

- Very simple and fast
- Restful api connection

# Installation

You can install the package via composer:

```sh
composer require mlk9/ippanel-laravel
```

then publish vendor

```sh
php artisan vendor:publish --tag=ippanel-laravel
```

# Setting up your IPPanel

```sh
// config/services.php
'ippanel' => [
        'server' => 'https://ippanel.com/services.jspd',
        'username' => 'YOUR_IPPANEL_USERNAME',
        'password' => 'YOUR_IPPANEL_PASSWORD',
        'originator' => 'YOUR_IPPANEL_ORIGINATOR',
],
```

# Usage

## Facade

```
<?php
use Mlk9\Sms\Facades\Sms;
//get credit
Sms::getCredit(); // res : 933222.33
//send message
Sms::sendMessage(string $text,array|string $recipients); // bool
//send pattern message
Sms::sendPatternMessage(string $code_pattern,string $recipient,array $entries = []);// bool
```

## Notification

append `'sms'` to via return in notification.
Then use `toSms` function like this:

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
//for pattern sms
public function toSms($notifiable)
        {
        return [
            'type' => 'patternMessage',
            'code' => 'YOUR CODE PATTERN',//string
            'values' => ['name'=>$notifiable->name],//array
            'recipient'=>  $notifiable->phone,//string
        ];
    }
//for simple sms
//    public function toSms($notifiable)
//    {
//        return [
//            'type' => 'message',
//            'message' => 'YOUR MESSAGE',
//            'recipient'=>  [$notifiable->phone], // shoud be arrray
//        ];
//     }


```
