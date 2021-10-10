<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Nodes;

use InvalidArgumentException;

class Node
{
    private $value;

    private ?Node $left = null;

    private ?Node $right = null;

    public function __construct($value)
    {
        $this->setValue($value);
    }

    public function setLeft(?Node $node = null)
    {
        $this->left = $node;
    }

    public function setRight(?Node $node = null)
    {
        $this->right = $node;
    }

    public function setValue($value)
    {
        if (! is_numeric($value)) {
            throw new InvalidArgumentException('The value of a node must be numeric');
        }

        $this->value = $value;
    }

    public function getLeft()
    {
        return $this->left;
    }

    public function getRight()
    {
        return $this->right;
    }

    public function getValue()
    {
        return $this->value;
    }
}
