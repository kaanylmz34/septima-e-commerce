<?php

namespace App\Core\DataUnits\Rules\Str;

use App\Core\DataUnits\Rules\Rule;

class Regex extends Rule
{

    protected string $errorMessage;
    protected string $pattern;

    public function __construct(string $pattern, ?string $errorMessage = null)
    {
        $this->pattern = $pattern;
        $this->errorMessage = $errorMessage ?? sprintf('The string must match the regex %s', $this->pattern);
    }

    public function isValid(mixed $value): bool
    {
        return preg_match($this->pattern, $value) === 1;
    }
    
}