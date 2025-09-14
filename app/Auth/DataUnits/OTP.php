<?php

namespace App\Auth\DataUnits;

use App\Core\DataUnits\Number;
use App\Core\DataUnits\Rules\Number\Length;

class Password extends Number
{
    protected array $rules;

    public function __construct(string $value)
    {
        parent::__construct($value);

        $this->rules = [
            new Length(length: 6, errorMessage: 'The OTP must be 6 characters long'),
        ];
    }
}