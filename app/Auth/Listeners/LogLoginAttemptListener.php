<?php

namespace App\Auth\Listeners;

use App\Auth\Events\BeforeLoginEvent;
use Illuminate\Support\Facades\Log;

class LogLoginAttemptListener
{
    public function handle(BeforeLoginEvent $event)
    {
        // TODO: Log işlemleri
    }
}