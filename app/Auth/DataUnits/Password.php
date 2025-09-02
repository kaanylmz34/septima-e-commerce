<?php

namespace App\Auth\DataUnits;

use App\Core\DataUnits\Str;
use App\Core\DataUnits\Rules\Str\Max;
use App\Core\DataUnits\Rules\Str\Min;

class Password extends Str
{

    protected array $rules;

    public function __construct(string $value)
    {
        parent::__construct($value);

        $this->rules = [
            new Max(30),
            new Min(8),
        ];
    }

}