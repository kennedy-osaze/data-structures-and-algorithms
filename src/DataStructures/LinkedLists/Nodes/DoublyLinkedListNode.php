<?php

namespace KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\LinkedLists\Nodes;

class DoublyLinkedListNode extends Node
{
    /**
     * Holds reference to the previous node
     *
     * @var static|null
     */
    private $previous = null;

    /**
     * Sets the previous node reference
     *
     * @param static|null $node
     *
     * @return void
     */
    public function setPrevious(DoublyLinkedListNode $node = null)
    {
        $this->previous = $node;
    }

    /**
     * Gets the previous node reference
     *
     * @return static|null
     */
    public function getPrevious()
    {
        return $this->previous;
    }
}
