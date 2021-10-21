<?php

namespace KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\LinkedLists\Nodes;

abstract class Node
{
    /**
     * Pointer to the next node
     *
     * @var static|null
     */
    private $next;

    /**
     * The data stored in the node
     *
     * @var mixed
     */
    private $data;

    public function __construct($data, $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }

    /**
     * Get the data stored in the node
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the data in the node
     *
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Get the next node reference
     *
     * @return static|null
     */
    public function getNext()
    {
        return $this->next;
    }

    /**
     * Set the next node reference
     *
     * @return void
     */
    public function setNext(Node $next = null)
    {
        $this->next = $next;
    }
}
