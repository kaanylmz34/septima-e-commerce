<?php

namespace App\Core\DataUnits\Exceptions;

use Exception;

class DataValidationException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct(sprintf('Data validation failed: %s', $message));
    }
}
