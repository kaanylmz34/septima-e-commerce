<?php

namespace App\Auth\Listeners;

use App\Auth\Events\BeforeLoginEvent;
use Illuminate\Support\Facades\Log;

class LoginAttemptAuditListener
{
    public function handle(BeforeLoginEvent $event)
    {
        Log::info('Login attempt via ' . $event->authCredentialsObject->method . ' method from this IP address: ' . request()->ip());
    }
}