<?php

namespace App\Auth\Events;

use Illuminate\Foundation\Events\Dispatchable;

class OtpGeneratedEvent
{
    use Dispatchable;

    public function __construct(
        public string $phone,
        public int $otp,
    ) 
    {}
}