# IPPanel Laravel

پکیج لاراولی ارسال اس ام اس سازگار با نوتیفیکیشن برای آپی پنل

# نیازمندی ها

- لاراول 6+
- PHP 7.4+

# ویژگی ها

- سریع و ساده
- اتصال امن 
- سازگار با نوتیفیکیشن

# نصب

نصب پکیج به وسیله کامپوزر:

```sh
composer require mlk9/ippanel-laravel
```

عمومی کردن تنظیمات 

```sh
php artisan vendor:publish --tag=ippanel-laravel
```

# جزئیات دقیق کانفیگ

```sh
// config/services.php
'ippanel' => [
        'server' => 'https://ippanel.com/services.jspd',
        'username' => 'YOUR_IPPANEL_USERNAME',
        'password' => 'YOUR_IPPANEL_PASSWORD',
        'originator' => 'YOUR_IPPANEL_ORIGINATOR',
],
```

# استفاده

## با استفاده از فساد

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

## با استفاده از نوتیفیکیشن لاراول

افزودن `'sms'` به نوتیفیکیشن مد نظر
و ایجاد فانکشن `toSms` به این شکل :

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
