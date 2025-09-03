<?php

namespace App\Core;

use App\Core\DataUnits\Exceptions\DataValidationException;

abstract class DataUnit
{

    public function __construct(protected array $rules = [], mixed $value = null)
    {
        if ($value)
        {
            $this->value = $value;
        }
    }
    
    protected function validate()
    {
        foreach ($this->rules as $rule) 
        {
            try
            {
                $rule->validate($this->value);
            }
            catch (\Exception $e)
            {
                throw new \Exception('Data validation failed: ' . $e->getMessage());
            }
        }
    }
    
    public function get()
    {
        try
        {
            $this->validate();
            return $this->value;
        }
        catch (DataValidationException $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    public function set(mixed $value): void
    {
        try
        {
            $this->validate();
            $this->value = $value;
        }
        catch (DataValidationException $e)
        {
            throw new \Exception($e->getMessage());
        }
    }

}