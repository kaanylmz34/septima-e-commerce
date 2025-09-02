<?php

namespace App\Core\DataUnits\Rules\Str;

use App\Core\DataUnits\Rules\Rule;

class Max extends Rule
{
    public function __construct(private int $max)
    {
        // ...
    }
    
    public function validate(string $value): bool
    {
        $condition = strlen($value) <= $this->max;

        if (!$condition)
        {
            throw new \Exception('The string must be less than ' . $this->max . ' characters');
        }

        return $condition;
    }
    
}