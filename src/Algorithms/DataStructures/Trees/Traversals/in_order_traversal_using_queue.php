<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\Traversals;

use Closure;
use KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Nodes\Node;
use KennedyOsaze\DataStructures\Queues\Queue;

function levelOrderTraversalUsingQueue(Node $node, Closure $callback)
{
    $queue = new Queue();

    $queue->enqueue($node);

    while (! $queue->isEmpty()) {
        $node = $queue->dequeue();

        $callback($node);

        if ($node->getLeft() !== null) {
            $queue->enqueue($node->getLeft());
        }

        if ($node->getRight() !== null) {
            $queue->enqueue($node->getRight());
        }
    }
}
