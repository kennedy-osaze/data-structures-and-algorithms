<?php

namespace KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\Trees\BinaryTrees\Nodes;

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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function getUncle(): ?self
    {
        $parent = $this->getParent();

        if ($parent === null) {
            return null;
        }

        return $parent->getSibling();
    }

    public function getSibling(): ?self
    {
        $parent = $this->getParent();

        if ($parent === null) {
            return null;
        }

        return ($parent->getLeft() === $this) ? $parent->getRight() : $parent->getLeft();
    }
}
