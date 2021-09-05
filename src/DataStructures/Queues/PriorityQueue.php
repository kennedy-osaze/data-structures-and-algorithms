<?php

namespace KennedyOsaze\DataStructures\Queues;

use KennedyOsaze\DataStructures\LinkedLists\Nodes\SinglyLinkedListNode as Node;

class PriorityQueue
{
    private ?Node $first = null;

    private ?Node $last = null;

    public function enqueue($data, int $priority)
    {
        $node = $this->createNode($data, $priority);

        if (is_null($this->first)) {
            $this->first = $this->last = $node;

            return;
        }

        $previous = null;
        $current = $this->first;
        $added = false;

        while(! is_null($current)) {
            if ($priority >= $current->getData()->priority) {
                $previous = $current;
                $current = $current->getNext();
            } else {
                if ($current === $this->first || $previous === null) {
                    $node->setNext($current);
                    $this->first = $node;
                } else {
                    $previous->setNext($node);
                    $node->setNext($current);
                }

                $added = true;
                break;
            }
        }

        if (! $added) {
            $this->last->setNext($node);
            $this->last = $node;
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
        return $this->first->getData()->value;
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
            $list[] = $current->getData()->value;

            $current = $current->getNext();
        }

        return $list;
    }

    private function createNode($data, int $priority)
    {
        return new Node((object) ['value' => $data, 'priority' => $priority]);
    }
}
