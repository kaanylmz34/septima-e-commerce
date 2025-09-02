<?php

namespace App\Core\DataUnits\Rules\Str;

use App\Core\DataUnits\Rules\Rule;

class Regex extends Rule
{

    public function __construct(private string $pattern)
    {
        // ...
    }

    public function validate(string $value): bool
    {
        $condition = preg_match($this->pattern, $value) === 1;
        
        if (!$condition)
        {
            throw new \Exception('The string must match the regex ' . $this->pattern);
        }

        return $condition;
    }

    
}