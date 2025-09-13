<?php

namespace App\Auth\Events;

use App\Auth\Objects\AuthCredentialsObject;
use Illuminate\Foundation\Events\Dispatchable;

class LoginLockedOutEvent
{
    use Dispatchable;

    public $primaryCredential;

    public function __construct(string $primaryCredential)
    {
        $this->primaryCredential = $primaryCredential;
    }
}