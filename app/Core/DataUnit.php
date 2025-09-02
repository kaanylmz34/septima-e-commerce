<?php

namespace App\Core;

use App\Core\DataUnits\Exceptions\DataValidationException;

abstract class DataUnit
{

    public function __construct(protected array $rules = [])
    {
        // ...
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
    
    public function get(): string
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

    public function set(string $value): void
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