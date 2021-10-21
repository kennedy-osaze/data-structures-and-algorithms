<?php

namespace KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\LinkedLists;

use KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode;

class SinglyLinkedList extends LinkedList
{
    /**
     * @inheritDoc
     */
    public function prepend($value)
    {
        $node = $this->createNodeFromValue($value);

        if ($this->head === null) {
            return $this->addFirstNode($node);
        }

        $node->setNext($this->head);

        $this->head = $node;

        $this->size += 1;
    }

    /**
     * @inheritDoc
     */
    public function append($value)
    {
        $node = $this->createNodeFromValue($value);

        if ($this->head === null) {
            return $this->addFirstNode($node);
        }

        $this->tail->setNext($node);

        $this->tail = $node;

        $this->size += 1;
    }

    /**
     * @inheritDoc
     */
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
        $previous->setNext($node);

        $this->size++;
    }

    /**
     * Removes the first node in the Linked list and returns its data
     *
     * @return mixed
     */
    public function deleteFirst()
    {
        if ($this->head === null) {
            return $this->head;
        }

        $node = $this->head;

        if ($this->head === $this->tail) {
            $this->head = $this->tail = null;
        } else {
            $this->head = $this->head->getNext();
        }

        $this->size--;

        return $node->getData();
    }

    /**
     * @inheritDoc
     */
    public function delete(int $index)
    {
        if (! $this->isIndexValid($index)) {
            return null;
        }

        if ($index === 0 || $this->size === 1) {
            return $this->deleteFirst();
        }

        $previous = $this->traverseToIndex($index - 1);
        $holding = $previous->getNext();
        $previous->setNext($holding->getNext());

        if ($index === $this->size - 1) {
            $this->tail = $previous;
        }

        $this->size--;

        return $holding->getData();
    }

    /**
     * Create a Singly linked list node using the specified value
     *
     * @param mixed $value
     *
     * @return \KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode
     */
    protected function createNodeFromValue($value)
    {
        return ($value instanceof SinglyLinkedListNode) ? $value : new SinglyLinkedListNode($value);
    }
}
