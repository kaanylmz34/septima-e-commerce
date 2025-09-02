<?php

namespace App\Core\DataUnits\Rules\Str;

use App\Core\DataUnits\Rules\Rule;

class Min extends Rule
{
    public function __construct(private int $min)
    {
        // ...
    }

    public function validate(string $value): bool
    {
        $condition = strlen($value) >= $this->min;
        
        if (!$condition) 
        {
            throw new \Exception('The string must be greater than ' . $this->min . ' characters');
        }

        return $condition;
    }


    
}