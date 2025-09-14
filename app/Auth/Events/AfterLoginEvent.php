<?php

namespace App\Auth\Events;

use App\Auth\Objects\AuthCredentialsObject;
use Illuminate\Foundation\Events\Dispatchable;

class AfterLoginEvent
{
    use Dispatchable;

    public function __construct(
        public AuthCredentialsObject $authCredentials, 
        public bool $status
    )
    {
    }
}