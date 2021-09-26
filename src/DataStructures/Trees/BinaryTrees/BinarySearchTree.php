<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees;

class BinarySearchTree
{
    private ?Node $root = null;

    private int $size = 0;

    public function __construct($rootValue = null)
    {
        if ($rootValue !== null) {
            $this->root = $this->createNode($rootValue);
        }
    }

    public function insert($value)
    {
        $node = $this->createNode($value);

        if ($this->root === null) {
            $this->root = $node;

            return;
        }

        $this->insertNode($this->root, $node);

        $this->size++;
    }

    private function insertNode(Node $parent, Node $node)
    {
        if ($parent->getValue() > $node->getValue()) {
            if ($parent->getLeft() === null) {
                $parent->setLeft($node);
            } else {
                $this->insertNode($parent->getLeft(), $node);
            }
        } else {
            if ($parent->getRight() === null) {
                $parent->setRight($node);
            } else {
                $this->insertNode($parent->getRight(), $node);
            }
        }
    }

    public function delete($value)
    {
        return $this->deleteNode($this->root, $value);
    }

    private function deleteNode(?Node $node = null, $value)
    {
        if ($node === null) {
            return null;
        }

        if ($node->getValue() > $value) {
            $node->setLeft($this->deleteNode($node, $value));

            return $node;
        }

        if ($node->getValue() < $value) {
            $node->setRight($this->deleteNode($node, $value));

            return $node;
        }

        if ($node->getLeft() === null && $node->getRight() === null) {
            return null;
        }

        if ($node->getLeft() === null || $node->getRight() === null) {
            $newNode = ($node->getLeft() === null) ? $node->getRight() : $node->getLeft();
            $node = null;

            return $newNode;
        }

        $newNode = $this->maximumNode($node->getLeft());
        $node->setValue($newNode->getValue());
        $this->deleteNode($node->getLeft(), $newNode->getValue());

        $this->size--;

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

    private function maximumNode(Node $node = null)
    {
        while ($node !== null && $node->getRight() !== null) {
            $node = $node->getRight();
        }

        return $node;
    }

    private function minimumNode(Node $node = null)
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
                return true;
            }

            if ($current->getValue() > $value) {
                $current = $current->getLeft();
            } else {
                $current = $current->getRight();
            }
        }

        return false;
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

    private function convertNodeToArray(?Node $node = null)
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

    private function createNode($value)
    {
        return $value instanceof Node ? $value : new Node($value);
    }
}
