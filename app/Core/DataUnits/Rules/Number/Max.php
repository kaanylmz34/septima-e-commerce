<?php

namespace App\Core\DataUnits\Rules\Number;

use App\Core\DataUnits\Rules\Rule;

class Max extends Rule
{

    protected string $errorMessage;

    public function __construct(private int $max, ?string $errorMessage = null)
    {
        $this->errorMessage = $errorMessage ?? sprintf('The number must be less than %d', $this->max);
    }

    public function isValid(mixed $value): bool
    {
        return $value < $this->max;
    }
    
}