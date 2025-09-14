<?php

namespace App\Auth\Events;

use App\Auth\Objects\AuthCredentialsObject;
use Illuminate\Foundation\Events\Dispatchable;

class LoginLockedOutEvent
{
    use Dispatchable;

    public function __construct(public string $primaryCredential)
    {
        $this->primaryCredential = $primaryCredential;
    }
}