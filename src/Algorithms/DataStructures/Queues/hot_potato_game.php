<?php

namespace KennedyOsaze\Algorithms\DataStructures\Queues;

use KennedyOsaze\DataStructures\Queues\Queue;

function hotPotatoGame(array $list)
{
    $queue = new Queue();
    $num = random_int(1, 10);

    foreach ($list as $item) {
        $queue->enqueue($item);
    }

    while ($queue->count() > 1) {
        for ($i = 0; $i < $num; $i++) {
            $queue->enqueue($queue->dequeue());
        }

        $eliminated = $queue->dequeue();
        echo "{$eliminated} has be eliminated from the game.<br>";
    }

    $winner = $queue->dequeue();

    echo "The winner is: {$winner}";
}
