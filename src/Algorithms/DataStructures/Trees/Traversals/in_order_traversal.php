<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\Traversals;

use Closure;
use KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Node;

function inOrderTraversal(?Node $node = null, Closure $callback)
{
    if ($node === null) {
        return;
    }

    inOrderTraversal($node->getLeft(), $callback);

    $callback($node);

    inOrderTraversal($node->getRight(), $callback);
}
