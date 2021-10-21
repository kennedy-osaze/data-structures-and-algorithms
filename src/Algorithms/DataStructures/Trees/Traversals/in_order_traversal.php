<?php

namespace KennedyOsaze\DataStructuresAndAlgorithms\Algorithms\DataStructures\Trees\Traversals;

use Closure;
use KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\Trees\BinaryTrees\Nodes\Node;

function inOrderTraversal(?Node $node = null, Closure $callback)
{
    if ($node === null) {
        return;
    }

    inOrderTraversal($node->getLeft(), $callback);

    $callback($node);

    inOrderTraversal($node->getRight(), $callback);
}
