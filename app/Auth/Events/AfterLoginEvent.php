<?php

namespace App\Auth\Events;

use App\Auth\Objects\AuthCredentialsObject;
use Illuminate\Foundation\Events\Dispatchable;

class AfterLoginEvent
{
    use Dispatchable;

    public $authCredentials;
    public $status;
    
    public function __construct(AuthCredentialsObject $authCredentials, bool $status)
    {
        $this->authCredentials = $authCredentials;
        $this->status = $status;
    }
}