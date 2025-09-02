<?php

namespace App\Auth\Services;

use App\Auth\Objects\AuthCredentialsObject;

class LoginService
{
    public function login(AuthCredentialsObject $authCredentialsObject)
    {
        echo $authCredentialsObject->email . ' - ' . $authCredentialsObject->password;
    }
}
