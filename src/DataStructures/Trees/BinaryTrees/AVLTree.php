<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees;

use KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Nodes\Node;

class AVLTree extends BinarySearchTree
{
    protected function insertNode(Node $node, ?Node $parent = null)
    {
        if ($parent === null) {
            $this->size++;

            return $node;
        }

        if ($parent->getValue() > $node->getValue()) {
            $parent->setLeft($this->insertNode($node, $parent->getLeft()));

            $parent = $this->balance($parent);
        } elseif ($parent->getValue() < $node->getValue()) {
            $parent->setRight($this->insertNode($node, $parent->getRight()));

            $parent = $this->balance($parent);
        }

        return $parent;
    }

    protected function deleteNode(?Node $node = null, $value)
    {
        $node = parent::deleteNode($node, $value);

        $balanceFactor = $this->getBalanceFactor($node);

        if ($balanceFactor > 1) {
            if ($this->getBalanceFactor($node->getLeft()) >= 0) {
                return $this->rotateRight($node);
            }

            return $this->rotateLeftRight($node);
        } elseif ($balanceFactor < -1) {
            if ($this->getBalanceFactor($node->getRight()) >= 0) {
                return $this->rotateLeft($node);
            }

            return $this->rotateRightLeft($node);
        }

        return $node;
    }

    private function balance(Node $node)
    {
        $balanceFactor = $this->getBalanceFactor($node);

        if ($balanceFactor > 1) {
            if ($this->getBalanceFactor($node->getLeft()) > 0) {
                return $this->rotateRight($node);
            }

            return $this->rotateLeftRight($node);
        } elseif ($balanceFactor < -1) {
            if ($this->getBalanceFactor($node->getRight()) > 0) {
                return $this->rotateRightLeft($node);
            }

            return $this->rotateLeft($node);
        }

        return $node;
    }

    private function getBalanceFactor(Node $node)
    {
        return $this->height($node->getLeft()) - $this->height($node->getRight());
    }

    private function rotateLeft(Node $node): Node
    {
        $temp = $node->getRight();

        $node->setRight($temp->getLeft());
        $temp->setLeft($node);

        return $temp;
    }

    private function rotateRight(Node $node): Node
    {
        $temp = $node->getLeft();

        $node->setLeft($temp->getRight());
        $temp->setRight($node);

        return $temp;
    }

    private function rotateLeftRight(Node $node): Node
    {
        $temp = $this->rotateLeft($node->getLeft());
        $node->setLeft($temp);

        return $this->rotateRight($node);
    }

    private function rotateRightLeft(Node $node): Node
    {
        $temp = $this->rotateRight($node->getRight());
        $node->setRight($temp);

        return $this->rotateLeft($node);
    }
}
