<?php

namespace KennedyOsaze\DataStructures\LinkedLists;

use KennedyOsaze\DataStructures\LinkedLists\Nodes\DoublyLinkedListNode;

class DoublyLinkedList extends LinkedList
{
    public function prepend($value)
    {
        $node = $this->createNodeFromValue($value);

        if ($this->head === null) {
            return $this->addFirstNode($node);
        }

        $this->head->setPrevious($node);
        $node->setNext($this->head);

        $this->head = $node;

        $this->size += 1;
    }

    public function append($value)
    {
        $node = $this->createNodeFromValue($value);

        if ($this->head === null) {
            return $this->addFirstNode($node);
        }

        $this->tail->setNext($node);
        $node->setPrevious($this->tail);

        $this->tail = $node;

        $this->size += 1;
    }

    public function insert(int $index, $value)
    {
        if ($index < 0) {
            return;
        }

        if ($index >= $this->size) {
            return $this->append($value);
        }

        if ($index === 0) {
            return $this->prepend($value);
        }

        $node = $this->createNodeFromValue($value);

        $previous = $this->traverseToIndex($index - 1);

        $holding = $previous->getNext();
        $node->setNext($holding);
        $node->setPrevious($previous);
        $holding->setPrevious($node);
        $previous->setNext($node);

        $this->size++;
    }

    public function removeFirst()
    {
        if ($this->head === null) {
            return $this->head;
        }

        $node = $this->head;

        if ($this->head === $this->tail) {
            $this->head = $this->tail = null;
        } else {
            $this->head = $this->head->getNext();
            $this->head->setPrevious(null);
        }

        $this->size--;

        return $node->getData();
    }

    public function removeLast()
    {
        if ($this->tail === null) {
            return;
        }

        $node = $this->tail;

        if ($this->head === $this->tail) {;
            $this->head = $this->tail = null;
        } else {
            $previous = $node->getPrevious();
            $previous->setNext(null);
            $this->tail = $previous;

            if ($previous->getPrevious() === null) {
                $this->head = $this->tail;
            }
        }

        $this->size--;

        return $node->getData();
    }

    public function remove(int $index)
    {
        if (! $this->isIndexValid($index)) {
            return null;
        }

        if ($index === 0 || $this->head === $this->tail) {
            return $this->removeFirst();
        }

        if (($index + 1) === $this->size) {
            return $this->removeLast();
        }

        $current = $this->traverseToIndex($index);
        $previous = $current->getPrevious();
        $next = $current->getNext();

        $previous->setNext($next);
        $next->setPrevious($previous);

        $this->size--;

        return $current->getData();
    }

    /**
     * Create a Singly linked list node using the specified value
     *
     * @param mixed $value
     *
     * @return \KennedyOsaze\DataStructures\LinkedLists\Nodes\DoublyLinkedListNode
     */
    protected function createNodeFromValue($value)
    {
        return ($value instanceof DoublyLinkedListNode)
            ? $value
            : new DoublyLinkedListNode($value);
    }
}
