<?php

namespace App\Auth\Events;

use App\Auth\Objects\AuthCredentialsObject;
use Illuminate\Foundation\Events\Dispatchable;

class BeforeLoginEvent
{
    use Dispatchable;

    public $authCredentials;

    public function __construct(AuthCredentialsObject $authCredentials)
    {
        $this->authCredentials = $authCredentials;
    }
}