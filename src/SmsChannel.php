<?php

namespace Mlk9\Sms\Sms;

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
    public function send($notifiable, Notification $notification): ?array
    {
        
    }
}