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

    public function __construct(string $method, ...$credentials) 
    {

        switch (true)
        {
            // E-posta - şifre girişi
            case $method === 'email' && Validator::make($credentials, [
                'email' => 'required|string',
                'password' => 'required|string',
            ])->passes():
            
                $this->fields = [
                    'email' => new Str($credentials['email']),
                    'password' => new Str($credentials['password']),
                ];
                $this->method = $method;

                break;

            // Telefon girişi
            case $method === 'phone' && Validator::make($credentials, [
                'phone' => 'required|string',
            ])->passes():

                $this->fields = [
                    'phone' => new Phone($credentials['phone']),
                ];
                $this->method = $method;
                
                break;

            default:
                throw new \Exception('Invalid credentials');
        }

    }
    
}