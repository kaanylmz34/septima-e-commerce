<?php

namespace App\Auth\Objects;

use App\Core\DataUnits\Str;
use App\Auth\DataUnits\Password;
use App\Core\DataObject;

class AuthCredentialsObject extends DataObject
{

    protected array $fields = [];

    public function __construct(
        string $email,
        string $password,
    ) 
    {

        $this->fields = [
            'email' => new Str($email),
            'password' => new Password($password),
        ];

    }
    
}