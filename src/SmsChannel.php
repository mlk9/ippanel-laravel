<?php

namespace Mlk9\Sms;

use Illuminate\Notifications\Notification;
use Mlk9\Sms\Facades\Sms;

/**
 * Class SmsChannel.
 */
class SmsChannel
{
    /**
     * Channel constructor.
     *
     */
    public function __construct()
    {
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
        if (!method_exists($notification, 'toSms')) {
            throw new \Exception('toSms class not exist !');
        }

        $data = $notification->toSms($notifiable);

        try {

            switch ($data['type']) {
                case 'message':
                    return Sms::sendMessage($data['message'], $data['recipient']);
                    break;
                case 'patternMessage':
                    return  Sms::sendPatternMessage($data['code'], $data['values'], $data['recipient']);
                    break;
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
