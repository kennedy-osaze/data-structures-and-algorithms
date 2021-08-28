<?php

namespace KennedyOsaze\DataStructures\LinkedLists;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use KennedyOsaze\DataStructures\LinkedLists\Interfaces\LinkedList as LinkedListInterface;
use KennedyOsaze\DataStructures\LinkedLists\Nodes\Node;

abstract class LinkedList implements LinkedListInterface, IteratorAggregate, Countable, ArrayAccess
{
    protected ?Node $head = null;

    protected ?Node $tail = null;

    protected int $size = 0;

    /**
     * Initialize Linked list
     *
     * @param mixed $value
     *
     * @return void
     */
    public function __construct($value = null)
    {
        if (! is_null($value)) {
            $this->addFirstNode($this->createNodeFromValue($value));
        }
    }

    /**
     * Creates a linked list
     *
     * @param mixed $value
     *
     * @return static
     */
    public static function create($value = null)
    {
        return new static($value);
    }

    /**
     * Adds the first node to the LinkedList
     *
     * @param \KennedyOsaze\DataStructures\LinkedLists\Nodes\Node $node
     *
     * @return void
     */
    protected function addFirstNode(Node $node)
    {
        $this->head = $this->tail = $node;

        $this->size += 1;
    }

    /**
     * @inheritDoc
     */
    public function search($value)
    {
        $current = $this->head;

        $index = 0;
        while ($current !== null) {
            if ($current->getData() === $value) {
                return $index;
            }

            $current = $current->getNext();
            $index++;
        }

        return -1;
    }

    /**
     * Reverses the linked list by creating another
     *
     * @return static
     */
    public function reverse()
    {
        if ($this->head === null || $this->head === $this->tail) {
            return static::create($this->head);
        }

        $reversedList = static::create();

        $current = $this->head;

        while ($current !== null) {
            $reversedList->prepend($current->getData());

            $current = $current->getNext();
        }

        return $reversedList;
    }

    /**
     * Finds the node at the specified index
     *
     * @param int $index
     *
     * @return \KennedyOsaze\DataStructures\LinkedLists\Nodes\Node|\KennedyOsaze\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode|\KennedyOsaze\DataStructures\LinkedLists\Nodes\DoublyLinkedListNode|null
     */
    public function find(int $index)
    {
        return $this->offsetGet($index);
    }

    /**
     * Checks if the index provided is accessible
     *
     * @param int $index
     *
     * @return bool
     */
    protected function isIndexValid(int $index)
    {
        return $index >= 0 && $index < $this->size;
    }

    /**
     * Traverses through the linked list
     *
     * @param int $index
     *
     * @return \KennedyOsaze\DataStructures\LinkedLists\Nodes\Node|\KennedyOsaze\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode|\KennedyOsaze\DataStructures\LinkedLists\Nodes\DoublyLinkedListNode|null
     */
    protected function traverseToIndex(int $index)
    {
        $current = $this->head;
        $currentIndex = 0;

        while ($currentIndex < $index) {
            $current = $current->getNext();
            $currentIndex++;
        }

        return $current;
    }

    /**
     * Retrieves the data in the first node of the list
     *
     * @return mixed
     */
    public function peekFirst()
    {
        if ($this->head === null) {
            return null;
        }

        return $this->head->getData();
    }

    /**
     * Retrieves the data in the last node of the list
     *
     * @return mixed
     */
    public function peekLast()
    {
        if ($this->tail === null) {
            return null;
        }

        return $this->tail->getData();
    }

    /**
     * Transforms the list to its array equivalent
     *
     * @return array
     */
    public function toArray()
    {
        $list = [];
        $current = $this->head;

        while ($current !== null) {
            array_push($list, $current->getData());

            $current = $current->getNext();
        }

        return $list;
    }

    /**
     * Get the node the LinkedList head is referencing
     *
     * @return \KennedyOsaze\DataStructures\LinkedLists\Nodes\Node|\KennedyOsaze\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode|\KennedyOsaze\DataStructures\LinkedLists\Nodes\DoublyLinkedListNode|null
     */
    public function getHead()
    {
        return $this->head;
    }

    /**
     * Get the node the LinkedList tail is referencing
     *
     * @return \KennedyOsaze\DataStructures\LinkedLists\Nodes\Node|\KennedyOsaze\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode|\KennedyOsaze\DataStructures\LinkedLists\Nodes\DoublyLinkedListNode|null
     */
    public function getTail()
    {
        return $this->tail;
    }

    /**
     * @see Countable::count
     *
     * @return int
     */
    public function count()
    {
        return $this->size;
    }

    /**
     * Iterator for Linked list
     *
     * @return \Generator|\KennedyOsaze\DataStructures\LinkedLists\Nodes\Node[]|\KennedyOsaze\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode[]|\KennedyOsaze\DataStructures\LinkedLists\Nodes\DoublyLinkedListNode[]|null
     */
    public function getIterator()
    {
        return (function () {
            $current = $this->head;

            while ($current !== null) {
                yield $current;

                $current = $current->getNext();
            }
        })();
    }

    /**
     * @see ArrayAccess::offsetGet
     *
     * @param int $offset
     */
    public function offsetGet($offset)
    {
        if (! $this->isIndexValid($offset)) {
            return null;
        }

        return $this->traverseToIndex($offset);
    }

    /**
     * @see ArrayAccess::offsetExists
     *
     * @param int $offset
     */
    public function offsetExists($offset)
    {
        return $this->offsetGet($offset) !== null;
    }

    /**
     * @see ArrayAccess::offsetUnset
     *
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            $this->delete($offset);
        }
    }

    /**
     * @see ArrayAccess::offsetSet
     *
     * @param int $offset
     */
    public function offsetSet($offset, $value)
    {
        if ($node = $this->offsetGet($offset)) {
            $node->setData($value);
        }
    }

    /**
     * Create a type of node using the specified value
     *
     * @param mixed $value
     *
     * @return \KennedyOsaze\DataStructures\LinkedLists\Nodes\Node
     */
    abstract protected function createNodeFromValue($value);
}
