<?php

namespace Mlk9\Sms;

use Illuminate\Notifications\Notification;

/**
 * Class SmsChannel.
 */
class SmsChannel
{
    /**
     * @var Sms
     */
    protected $Sms;

    /**
     * Channel constructor.
     *
     * @param Sms $Sms
     */
    public function __construct(Sms $Sms)
    {
        $this->Sms = $Sms;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @throws CouldNotSendNotification
     * @return null|array
     */
    public function send($notifiable, Notification $notification)
    {
        if(!method_exists($notification,'toSms'))
        {
            throw new \Exception('toSms class not exist !');
        }
        $data = $notification->toSms($notifiable);

        try {

            switch($data['type']){
                case 'message':
                    return $this->Sms->message($data['message'], $data['recipient'])->send();
                    break;
                case 'patternMessage':
                    return $this->Sms->patternMessage($data['code'], $data['values'],$data['recipient'])->send();
                    break;
            }
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }
}
