<?php

namespace KennedyOsaze\DataStructures\LinkedLists\Interfaces;

interface LinkedList
{
    /**
     * Adds the value to the beginning to the LinkedList
     *
     * @param mixed $value
     *
     * @return void
     */
    public function prepend($value);

    /**
     * Adds the value to the end to the LinkedList
     *
     * @param mixed $value
     *
     * @return void
     */
    public function append($value);

    /**
     * Inserts the value at a specified index of the LinkedList
     *
     * @param int $index
     *
     * @param mixed $value
     *
     * @return void
     */
    public function insert(int $index, $value);

    /**
     * Delete the node at the specified index, returning the value stored in that node
     *
     * @param int $index
     *
     * @return mixed
     */
    public function delete(int $index);

    /**
     * Searches through the LinkedList for the specified value
     * Returns the index of the node that has that value
     * If the node is not value, it returns a -1
     *
     * @param mixed $value
     *
     * @return int
     */
    public function search($value);
}
