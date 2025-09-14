<?php

namespace App\Auth\Listeners;

use App\Auth\Events\OtpGeneratedEvent;

class SendSmsAfterOtpGeneratedListener
{
    public function handle(OtpGeneratedEvent $event)
    {
        // OTP'yi işleme mantığı (örneğin, SMS gönderme)
        // Örnek: SmsService::send($event->phone, "Your OTP is: " . $event->otp);
    }
}