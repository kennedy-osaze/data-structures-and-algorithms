<?php

namespace KennedyOsaze\Algorithms\DataStructures\Trees\Traversals;

use Closure;
use KennedyOsaze\Algorithms\DataStructures\Trees\BinaryTrees\Nodes\Node;

function levelOrderTraversal(Node $node, Closure $callback)
{
    $level = 0;

    while (traverseNodeOnLevel($level, $node, $callback)) {
        $level++;
    }
}

function traverseNodeOnLevel(int $level, ?Node $node = null, Closure $callback)
{
    if ($node === null) {
        return false;
    }

    if ($level === 0) {
        $callback($node);

        return true;
    }

    $left = traverseNodeOnLevel($level - 1, $node->getLeft(), $callback);
    $right = traverseNodeOnLevel($level - 1, $node->getRight(), $callback);

    return $left || $right;
}
