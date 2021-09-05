<?php

namespace KennedyOsaze\Algorithms\DataStructures\Stacks;

class Stack
{
    private array $list = [];

    public function push($data)
    {
        array_push($this->list, $data);
    }

    public function pop()
    {
        return array_pop($this->list);
    }

    public function peek()
    {
        return $this->list[count($this->list) - 1];
    }

    public function count()
    {
        return count($this->list);
    }

    public function isEmpty()
    {
        return empty($this->list);
    }

    public function toArray()
    {
        return $this->list;
    }
}
