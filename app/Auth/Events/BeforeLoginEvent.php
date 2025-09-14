<?php

namespace App\Auth\Events;

use App\Auth\Objects\AuthCredentialsObject;
use Illuminate\Foundation\Events\Dispatchable;

class BeforeLoginEvent
{
    use Dispatchable;

    public function __construct(public AuthCredentialsObject $authCredentials)
    {
    }
}