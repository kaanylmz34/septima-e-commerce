<?php

namespace App\Core\DataUnits;

use App\Core\DataUnit;

class Number extends DataUnit
{

    public function __construct(protected int $value)
    {
        parent::__construct(value: $value);
    }

}