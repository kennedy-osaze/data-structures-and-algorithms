<?php

namespace KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\Queues;

use KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode as Node;

class Queue
{
    private ?Node $first = null;

    private ?Node $last = null;

    /**
     * Add data to the queue
     *
     * @param mixed $data
     *
     * @return void
     */
    public function enqueue($data)
    {
        $data = $this->createNode($data);

        if (is_null($this->first)) {
            $this->first = $this->last = $data;
        } else {
            $this->last->setNext($data);
            $this->last = $data;
        }
    }

    /**
     * Remove and returns the last data in the queue
     *
     * @return mixed
     */
    public function dequeue()
    {
        if (is_null($this->first)) {
            return null;
        }

        $first = $this->first;

        $this->first = $this->first->getNext();

        return is_null($first) ? $first : $first->getData();
    }

    /**
     * Return the last data in the queue
     *
     * @return mixed
     */
    public function peek()
    {
        return $this->first->getData();
    }

    /**
     * Check whether the queue is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        return is_null($this->first);
    }

    /**
     * Return the count of data in the queue
     *
     * @return int
     */
    public function count()
    {
        return count($this->toArray());
    }

    /**
     * Transforms the list to its array equivalent
     *
     * @return array
     */
    public function toArray()
    {
        $list = [];

        if (is_null($this->first)) {
            return $list;
        }

        $current = $this->first;

        while (! is_null($current)) {
            $list[] = $current->getData();

            $current = $current->getNext();
        }

        return $list;
    }

    /**
     * Create a node using the specified $data
     *
     * @return \KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode
     */
    private function createNode($data)
    {
        return $data instanceof Node ? $data : new Node($data);
    }
}
