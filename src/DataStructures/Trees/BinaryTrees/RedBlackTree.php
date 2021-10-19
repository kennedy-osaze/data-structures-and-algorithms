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

            $this->balanceInsertion($node);
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

    private function balanceInsertion(RedBlackNode $node)
    {
        $parent = $node->getParent();

        if ($parent === null || $parent->isBlack() || $parent->getParent() === null) {
            return;
        }

        $grandParent = $parent->getParent();
        $uncle = $node->getUncle();

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

        $this->balanceInsertion($grandParent);
    }

    public function delete($value)
    {
        $node = $this->search($value);

        if ($node === false) {
            return;
        }

        $this->deleteNode($node, $value);
    }

    protected function deleteNode(?Node $node = null, $value)
    {
        assert($node instanceof RedBlackNode);
        assert($node !== null);

        $replacerNode = $this->findReplacerNodeForDeletableNode($node);
        $parent = $node->getParent();

        $doubleBlackExists = ($replacerNode === null || $replacerNode->isBlack()) && $node->isBlack();

        // $node is basically a leaf node (has no child)
        if ($replacerNode === null) {
            if ($this->root === $node) {
                $this->root = null;
            } else {
                // $node is a black node
                if ($doubleBlackExists) {
                    $this->fixDoubleBlackAtNode($node);
                }

                if ($parent->getLeft() === $node) {
                    $parent->setLeft(null);
                } else {
                    $parent->setRight(null);
                }
            }

            return;
        }

        // $node has one child
        if ($node->getLeft() === null || $node->getRight() === null) {
            if ($node === $this->root) {
                $node->setValue($replacerNode->getValue());
                $node->setLeft(null);
                $node->setRight(null);

                return;
            }

            if ($parent->getLeft() === $node) {
                $parent->setLeft($replacerNode);
            } else {
                $parent->setRight($replacerNode);
            }

            $replacerNode->setParent($parent);

            if ($doubleBlackExists) {
                $this->fixDoubleBlackAtNode($replacerNode);
            } else {
                $replacerNode->makeBlack();
            }

            return;
        }

        // $node has two children, swap the values with the $replacerNode and recurse
        $value = $node->getValue();
        $node->setValue($replacerNode->getValue());
        $replacerNode->setValue($value);

        $this->deleteNode($replacerNode, $value);
    }

    private function findReplacerNodeForDeletableNode(RedBlackNode $node): ?RedBlackNode
    {
        if ($node->getLeft() === null && $node->getRight() === null) {
            return null;
        }

        if ($node->getLeft() === null || $node->getRight() === null) {
            return $node->getLeft() === null ? $node->getRight() : $node->getLeft();
        }

        return $this->minimumNode($node->getRight());
    }

    private function fixDoubleBlackAtNode(RedBlackNode $node)
    {
        if ($this->root === $node) {
            return;
        }

        $sibling = $node->getSibling();
        $parent = $node->getParent();

        if ($sibling === null) {
            return $this->fixDoubleBlackAtNode($parent);
        }

        if ($sibling->isRed()) {
            $sibling->makeBlack();
            $parent->makeRed();

            if ($parent->getLeft() === $node) {
                $this->rotateLeft($parent);
            } else {
                $this->rotateRight($parent);
            }

            return $this->fixDoubleBlackAtNode($node);
        }

        // $sibling has one of its children to be red
        if ($sibling->getLeft() !== null && $sibling->getLeft()->isRed()) {
            if ($parent->getLeft() === $sibling) {
                $sibling->isBlack() ? $sibling->getLeft()->makeBlack() : $sibling->getLeft()->makeRed();
                $parent->isBlack() ? $sibling->makeBlack() : $sibling->makeRed();

                $this->rotateRight($parent);
            } else {
                $parent->isBlack() ? $sibling->getLeft()->makeBlack() : $sibling->getLeft()->makeRed();

                $this->rotateRightLeft($parent);
            }

            $parent->makeBlack();
        } elseif ($sibling->getRight() !== null && $sibling->getRight()->isRed()) {
            if ($parent->getLeft() === $sibling) {
                $parent->isBlack() ? $sibling->getRight()->makeBlack() : $sibling->getRight()->makeRed();

                $this->rotateLeftRight($parent);
            } else {
                $sibling->isBlack() ? $sibling->getRight()->makeBlack() : $sibling->getRight()->makeRed();
                $parent->isBlack() ? $sibling->makeBlack() : $sibling->makeRed();

                $this->rotateLeft($parent);
            }

            $parent->makeBlack();
        } else {
            // sibling is a leaf or its children are both black
            $sibling->makeRed();

            if ($parent->isRed()) {
                $parent->makeBlack();
            } else {
                $this->fixDoubleBlackAtNode($parent);
            }
        }
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
