<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Nodes;

class RedBlackNode extends Node
{
    private const RED = 'red';
    private const BLACK = 'black';

    private ?RedBlackNode $parent = null;

    private string $colour;

    public function __construct($value)
    {
        parent::__construct($value);

        $this->makeRed();
    }

    public function makeRed()
    {
        $this->colour = self::RED;
    }

    public function makeBlack()
    {
        $this->colour = self::BLACK;
    }

    public function isRed()
    {
        return $this->colour === self::RED;
    }

    public function isBlack()
    {
        return $this->colour === self::BLACK;
    }

    public function getColour()
    {
        return $this->colour;
    }

    public function setParent(?RedBlackNode $node = null)
    {
        $this->parent = $node;
    }

    public function getParent()
    {
        return $this->parent;
    }
}
