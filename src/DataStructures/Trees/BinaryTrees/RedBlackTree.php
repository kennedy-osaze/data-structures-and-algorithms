<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees;

use KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Nodes\Node;
use KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Nodes\RedBlackNode;

class RedBlackTree extends BinarySearchTree
{
    public function insert($value)
    {
        $node = $this->createNode($value);

        if ($this->root === null) {
            $node->makeBlack();
            $this->root = $node;
        } else {
            $node = $this->insertRedBlackNode($node, $this->root);

            $this->balance($node);
        }

        $this->size++;
    }

    private function insertRedBlackNode(RedBlackNode $node, RedBlackNode $parent)
    {
        if ($parent->getValue() > $node->getValue()) {
            if ($parent->getLeft() === null) {
                $node->setParent($parent);
                $parent->setLeft($node);

                return $node;
            }

            return $this->insertRedBlackNode($node, $parent->getLeft());
        }

        if ($parent->getRight() === null) {
            $node->setParent($parent);
            $parent->setRight($node);

            return $node;
        }

        return $this->insertRedBlackNode($node, $parent->getRight());
    }

    private function balance(RedBlackNode $node)
    {
        $parent = $node->getParent();

        if ($parent === null || $parent->isBlack() || $parent->getParent() === null) {
            return;
        }

        $grandParent = $parent->getParent();
        $uncle = $grandParent->getLeft() === $parent ? $grandParent->getRight() : $grandParent->getLeft();

        if ($uncle === null || $uncle->isBlack()) {
            $this->rotate($node);
        } else {
            if ($grandParent !== $this->root) {
                $grandParent->makeRed();
            }

            $uncle->makeBlack();
            $parent->makeBlack();
        }

        if ($parent === null) {
            $node->makeBlack();
            $this->root = $node;
        }

        $this->balance($grandParent);
    }

    private function rotate(RedBlackNode $node)
    {
        $parent = $node->getParent();
        $grandParent = $parent->getParent();

        if ($grandParent->getLeft() === $parent) {
            if ($parent->getLeft() === $node) {
                $node = $this->rotateRight($grandParent);

                return $this->flipColorAfterRotation($node);
            }

            $node = $this->rotateLeftRight($grandParent);

            return $this->flipColorAfterRotation($node);
        }

        if ($parent->getRight() === $node) {
            $node = $this->rotateLeft($grandParent);

            return $this->flipColorAfterRotation($node);
        }

        $node = $this->rotateRightLeft($grandParent);

        return $this->flipColorAfterRotation($node);
    }

    private function rotateRight(RedBlackNode $node)
    {
        $temp = $node->getLeft();
        $node->setLeft($temp->getRight());

        if ($node->getLeft() !== null) {
            $node->getLeft()->setParent($node);
        }

        $parent = $node->getParent();

        if ($parent === null) {
            $this->root = $temp;
            $temp->setParent(null);
        } else {
            $temp->setParent($parent);

            if ($parent->getRight() === $node) {
                $parent->setRight($temp);
            } else {
                $parent->setLeft($temp);
            }
        }

        $temp->setRight($node);
        $node->setParent($temp);

        return $temp;
    }

    private function rotateLeftRight(RedBlackNode $node)
    {
        $temp = $this->rotateLeft($node->getLeft());

        $node->setLeft($temp);
        $temp->setParent($node);

        return $this->rotateRight($node);
    }

    private function rotateLeft(RedBlackNode $node)
    {
        $temp = $node->getRight();
        $node->setRight($temp->getLeft());

        if ($node->getRight() !== null) {
            $node->getRight()->setParent($node);
        }

        $parent = $node->getParent();

        if ($parent === null) {
            $this->root = $temp;
            $temp->setParent(null);
        } else {
            $temp->setParent($parent);

            if ($parent->getLeft() === $node) {
                $parent->setLeft($temp);
            } else {
                $parent->setRight($temp);
            }
        }

        $temp->setLeft($node);
        $node->setParent($temp);

        return $temp;
    }

    private function rotateRightLeft(RedBlackNode $node)
    {
        $temp = $this->rotateRight($node->getRight());

        $node->setRight($temp);
        $temp->setParent($node);

        return $this->rotateLeft($node);
    }

    private function flipColorAfterRotation(RedBlackNode $node)
    {
        $node->makeBlack();

        if ($node->getLeft() !== null) {
            $node->getLeft()->makeRed();
        }

        if ($node->getRight() !== null) {
            $node->getRight()->makeRed();
        }
    }

    protected function convertNodeToArray(?Node $node = null)
    {
        if ($node === null) {
            return null;
        }

        return [
            'value' => $node->getValue(),
            'color' => $node->getColour(),
            'left' => $this->convertNodeToArray($node->getLeft()),
            'right' => $this->convertNodeToArray($node->getRight()),
        ];
    }

    protected function createNode($value)
    {
        return $value instanceof RedBlackNode ? $value : new RedBlackNode($value);
    }
}
