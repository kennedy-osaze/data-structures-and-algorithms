<?php

namespace KennedyOsaze\DataStructures\HashTables;

class KeyValueObject
{
    private $key;

    private $value;

    public function __construct($key, $value)
    {
        $this->key = $key;

        $this->value = $value;
    }

    public static function create($key, $value)
    {
        return new self($key, $value);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }
}
