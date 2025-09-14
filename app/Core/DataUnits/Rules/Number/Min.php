<?php

namespace App\Core\DataUnits\Rules\Number;

use App\Core\DataUnits\Rules\Rule;

class Min extends Rule
{

    protected string $errorMessage;

    public function __construct(private int $min, ?string $errorMessage = null)
    {
        $this->errorMessage = $errorMessage ?? sprintf('The number must be greater than %d', $this->min);
    }

    public function isValid(mixed $value): bool
    {
        return $value > $this->min;
    }
    
}