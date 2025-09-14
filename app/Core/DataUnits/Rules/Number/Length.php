<?php

namespace App\Core\DataUnits\Rules\Number;

use App\Core\DataUnits\Rules\Rule;

class Length extends Rule
{

    protected string $errorMessage;

    public function __construct(private int $length, ?string $errorMessage = null)
    {
        $this->errorMessage = $errorMessage ?? sprintf('The number must be %d characters long', $this->length);
    }

    public function isValid(mixed $value): bool
    {
        return strlen((string)$value) === $this->length;
    }
    
}