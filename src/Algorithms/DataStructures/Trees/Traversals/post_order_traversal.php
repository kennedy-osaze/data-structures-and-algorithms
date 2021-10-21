<?php

namespace KennedyOsaze\DataStructuresAndAlgorithms\Algorithms\DataStructures\Trees\Traversals;

use Closure;
use KennedyOsaze\DataStructuresAndAlgorithms\DataStructures\Trees\BinaryTrees\Nodes\Node;

function postOrderTraversal(?Node $node = null, Closure $callback)
{
    if ($node === null) {
        return;
    }

    postOrderTraversal($node->getLeft(), $callback);
    postOrderTraversal($node->getRight(), $callback);

    $callback($node);
}
