<?php

namespace KennedyOsaze\DataStructuresAndAlgorithms\Algorithms\DataStructures\HashTables;

use KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\HashTables\KeyValueObject;
use KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\LinkedLists\SinglyLinkedList as LinkedList;

class HashTable
{
    private array $table = [];

    private int $size = 0;

    /**
     * Insert key and value into the hash table
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return void
     */
    public function insert($key, $value)
    {
        $address = $this->generateHash($key);
        $data = $this->createValueObject($key, $value);

        if (! isset($this->table[$address])) {
            $this->table[$address] = new LinkedList();
        }

        $this->table[$address]->append($data);
        $this->size++;
    }

    /**
     * Get the value with the key
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function get($key)
    {
        $address = $this->generateHash($key);

        if (! isset($this->table[$address]) || $this->table[$address]->count() === 0) {
            return null;
        }

        $current = $this->table[$address]->getHead();

        while ($current !== null) {
            $data = $current->getData();

            if ($data->getKey() === $key) {
                return $data->getValue();
            }

            $current = $current->getNext();
        }

        return null;
    }

    /**
     * Delete the value with the key from the hash table
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function delete($key)
    {
        $address = $this->generateHash($key);

        if (! isset($this->table[$address]) || $this->table[$address]->count() === 0) {
            return false;
        }

        $current = $this->table[$address]->getHead();
        $index = 0;

        while ($current !== null) {
            $data = $current->getData();

            if ($data->getKey() === $key) {
                $this->table[$address]->delete($index);

                $this->size--;

                return true;
            }

            $index++;
            $current = $current->getNext();
        }

        return false;
    }

    /**
     * Return the count of data in the hash table
     *
     * @return int
     */
    public function count()
    {
        return $this->size;
    }

    /**
     * Transform the hash table to its array equivalent
     *
     * @return array
     */
    public function toArray()
    {
        $list = [];

        foreach ($this->table as $linkedList) {
            foreach ($linkedList->toArray() as $data) {
                $list[$data->getKey()] = $data->getValue();
            }
        }

        return $list;
    }

    /**
     * Generate a hash based on the provided key
     *
     * @param mixed $key
     *
     * @return int
     */
    private function generateHash($key)
    {
        return crc32((string) $key) % 137;
    }

    /**
     * Create a key-value object
     *
     * @param mixed $key
     * @param mixed $value
     *
     * @return \KennedyOsaze\DataStructures\HashTables\KeyValueObject
     */
    private function createValueObject($key, $value)
    {
        return new KeyValueObject($key, $value);
    }
}
