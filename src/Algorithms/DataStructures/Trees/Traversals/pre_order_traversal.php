<?php

namespace KennedyOsaze\DataStructuresAndAlgorithms\Algorithms\DataStructures\Trees\Traversals;

use Closure;
use KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\Trees\BinaryTrees\Nodes\Node;

function preOrderTraversal(?Node $node = null, Closure $callback)
{
    if ($node === null) {
        return;
    }

    $callback($node);

    preOrderTraversal($node->getLeft(), $callback);
    preOrderTraversal($node->getRight(), $callback);
}
