<?php

namespace App\Auth\Objects;

use App\Core\DataUnits\Str;
use App\Core\DataUnits\Phone;
use App\Auth\DataUnits\Password;
use App\Core\DataObject;
use Illuminate\Support\Facades\Validator;

class AuthCredentialsObject extends DataObject
{

    protected array $fields = [];

    public string $method;

    public function __construct(...$credentials) 
    {

        switch (true)
        {
            // E-posta - şifre girişi
            case Validator::make($credentials, [
                'email' => 'required|string',
                'password' => 'required|string',
            ])->passes():
            
                $this->fields = [
                    'email' => new Str($credentials['email']),
                    'password' => new Str($credentials['password']),
                ];
                $this->method = 'email';

                break;

            // Telefon girişi
            case Validator::make($credentials, [
                'phone' => 'required|string',
            ])->passes():

                $this->fields = [
                    'phone' => new Phone($credentials['phone']),
                ];
                $this->method = 'phone';
                
                break;

            default:
                throw new \Exception('Invalid credentials');
        }

    }
    
}