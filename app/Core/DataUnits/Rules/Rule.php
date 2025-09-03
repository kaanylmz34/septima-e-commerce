<?php

namespace App\Core\DataUnits\Rules;

abstract class Rule
{

    protected string $errorMessage;
    protected mixed $value;

    abstract public function isValid(mixed $value): bool;

    public function __construct(?string $errorMessage)
    {
        if ($errorMessage)
            $this->errorMessage = $errorMessage;
    }

    public function validate(mixed $value): bool
    {
        if (!$this->isValid($value))
        {
            throw new \Exception($this->errorMessage);
        }

        return true;
    }

}