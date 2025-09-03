<?php

namespace App\Core\DataUnits;

use App\Core\DataUnits\Rules\Str\Regex;

class Phone extends Str
{
    protected array $rules;

    public function __construct(string $value)
    {
        parent::__construct($value);

        $this->rules = [
            new Regex('/^(\+90|0)\d{10}$/', errorMessage: 'The phone number is invalid.'),
        ];
    }
}
