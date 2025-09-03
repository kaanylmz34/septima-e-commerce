<?php

namespace App\Auth\Services;

use App\Auth\Objects\AuthCredentialsObject;

class LoginService
{
    public function login(AuthCredentialsObject $authCredentialsObject)
    {
        switch ($authCredentialsObject->method) 
        {
            case 'email':
                return $this->loginWithEmail($authCredentialsObject);
            case 'phone':
                return $this->loginWithPhone($authCredentialsObject);
        }
    }

    private function loginWithEmail(AuthCredentialsObject $authCredentialsObject)
    {
        Auth::attempt($authCredentialsObject->email, $authCredentialsObject->password);
    }

    private function loginWithPhone(AuthCredentialsObject $authCredentialsObject)
    {
        User::where('phone', $authCredentialsObject->phone)->first();
        if (!$user) 
        {
            throw new \Exception('User not found');
        }
        
        Auth::login($user);
    }
}
