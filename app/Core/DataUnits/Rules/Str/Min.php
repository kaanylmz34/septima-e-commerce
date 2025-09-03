<?php

namespace App\Core\DataUnits\Rules\Str;

use App\Core\DataUnits\Rules\Rule;

class Min extends Rule
{

    protected string $errorMessage;
    protected mixed $value;

    public function __construct(private int $min, ?string $errorMessage = null)
    {
        $this->errorMessage = $errorMessage ?? sprintf('The string must be greater than %d characters', $this->min);
    }

    public function isValid(mixed $value): bool
    {
        return strlen($value) >= $this->min;
    }
    
}