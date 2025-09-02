<?php

namespace App\Core;

abstract class DataObject
{
    protected array $fields = [];

    public function __get(string $name)
    {
        return $this->fields[$name]->get();
    }
}