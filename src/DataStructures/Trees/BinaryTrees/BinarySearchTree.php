<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees;

use KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Nodes\Node;

class BinarySearchTree
{
    protected ?Node $root = null;

    protected int $size = 0;

    public function __construct($rootValue = null)
    {
        if ($rootValue !== null) {
            $this->insert($rootValue);
        }
    }

    public function insert($value)
    {
        $node = $this->createNode($value);

        $this->root = $this->insertNode($node, $this->root);
    }

    protected function insertNode(Node $node, ?Node $parent = null)
    {
        if ($parent === null) {
            $this->size++;

            return $node;
        }

        if ($parent->getValue() > $node->getValue()) {
            $parent->setLeft($this->insertNode($node, $parent->getLeft()));
        } elseif ($parent->getValue() < $node->getValue()) {
            $parent->setRight($this->insertNode($node, $parent->getRight()));
        }

        return $parent;
    }

    public function delete($value)
    {
        $this->root = $this->deleteNode($this->root, $value);
    }

    protected function deleteNode(?Node $node = null, $value)
    {
        if ($node === null) {
            return null;
        }

        if ($node->getValue() > $value) {
            $node->setLeft($this->deleteNode($node->getLeft(), $value));

            return $node;
        }

        if ($node->getValue() < $value) {
            $node->setRight($this->deleteNode($node->getRight(), $value));

            return $node;
        }

        $this->size--;

        if ($node->getLeft() === null && $node->getRight() === null) {
            return null;
        }

        if ($node->getLeft() === null || $node->getRight() === null) {
            $newNode = ($node->getLeft() === null) ? $node->getRight() : $node->getLeft();
            $node = null;

            return $newNode;
        }

        $newNode = $this->minimumNode($node->getRight());
        $node->setValue($newNode->getValue());
        $node->setRight($this->deleteNode($node->getRight(), $newNode->getValue()));

        return $node;
    }

    public function min()
    {
        return $this->root ? $this->minimumNode($this->root) : null;
    }

    public function max()
    {
        return $this->root ? $this->maximumNode($this->root) : null;
    }

    protected function maximumNode(Node $node = null)
    {
        while ($node !== null && $node->getRight() !== null) {
            $node = $node->getRight();
        }

        return $node;
    }

    protected function minimumNode(Node $node = null)
    {
        while ($node !== null && $node->getLeft() !== null) {
            $node = $node->getLeft();
        }

        return $node;
    }

    public function search($value)
    {
        $current = $this->root;

        while ($current !== null) {
            if ($current->getValue() === $value) {
                return $current;
            }

            if ($current->getValue() > $value) {
                $current = $current->getLeft();
            } else {
                $current = $current->getRight();
            }
        }

        return false;
    }

    public function height()
    {
        $node = empty(func_get_args()) ? $this->root : func_get_arg(0);

        if ($node === null) {
            return -1;
        }

        $leftHeight = $this->height($node->getLeft());
        $rightHeight = $this->height($node->getRight());

        return max($leftHeight, $rightHeight) + 1;
    }

    public function count()
    {
        return $this->size;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function toArray()
    {
        if ($this->root === null) {
            return [];
        }

        return ['root' => $this->convertNodeToArray($this->root)];
    }

    protected function convertNodeToArray(?Node $node = null)
    {
        if ($node === null) {
            return null;
        }

        return [
            'value' => $node->getValue(),
            'left' => $this->convertNodeToArray($node->getLeft()),
            'right' => $this->convertNodeToArray($node->getRight()),
        ];
    }

    protected function createNode($value)
    {
        return $value instanceof Node ? $value : new Node($value);
    }
}
