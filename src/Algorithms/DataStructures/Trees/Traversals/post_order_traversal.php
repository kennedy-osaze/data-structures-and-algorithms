<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\Traversals;

use Closure;
use KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Node;

function postOrderTraversal(?Node $node = null, Closure $callback)
{
    if ($node === null) {
        return;
    }

    postOrderTraversal($node->getLeft(), $callback);
    postOrderTraversal($node->getRight(), $callback);

    $callback($node);
}
