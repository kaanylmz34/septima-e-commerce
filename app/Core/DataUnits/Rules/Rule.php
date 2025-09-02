<?php

namespace App\Core\DataUnits\Rules;

abstract class Rule
{

    abstract public function validate(string $value): bool;

}