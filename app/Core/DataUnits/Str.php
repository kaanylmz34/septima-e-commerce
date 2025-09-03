<?php

namespace App\Core\DataUnits;

use App\Core\DataUnit;

class Str extends DataUnit
{

    public function __construct(protected string $value)
    {
        parent::__construct(value: $value);
    }

}