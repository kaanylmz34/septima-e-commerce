<?php

namespace App\Auth\Services;

use App\Auth\Objects\AuthCredentialsObject;
use App\Auth\Events\BeforeLoginEvent;
use App\Auth\Events\AfterLoginEvent;
use Illuminate\Support\Facades\Auth;
use App\User\Models\User;

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
        event(new BeforeLoginEvent($authCredentialsObject));

        $status = Auth::attempt($authCredentialsObject->email, $authCredentialsObject->password);

        event(new AfterLoginEvent($authCredentialsObject, $status));

        return $authCredentialsObject;
    }

    private function loginWithPhone(AuthCredentialsObject $authCredentialsObject)
    {
        event(new BeforeLoginEvent($authCredentialsObject));

        $user = User::where('phone', $authCredentialsObject->phone)->first();
        if (!$user) 
        {
            throw new \Exception('User not found');
        }
        
        $status = Auth::login($user);

        event(new AfterLoginEvent($authCredentialsObject, $status));

        return $authCredentialsObject;
    }
}
