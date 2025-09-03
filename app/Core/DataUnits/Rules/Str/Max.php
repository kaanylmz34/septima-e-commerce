<?php

namespace App\Core\DataUnits\Rules\Str;

use App\Core\DataUnits\Rules\Rule;

class Max extends Rule
{

    protected string $errorMessage;
    protected mixed $value;

    public function __construct(private int $max, ?string $errorMessage = null)
    {
        $this->errorMessage = $errorMessage ?? sprintf('The string must be less than %d characters', $this->max);
    }

    public function isValid(mixed $value): bool
    {
        return strlen($value) <= $this->max;
    }
    
}