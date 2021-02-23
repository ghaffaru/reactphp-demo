<?php

use React\EventLoop\Factory;
use React\Stream\ReadableResourceStream;
use React\Stream\WritableResourceStream;

require '../vendor/autoload.php';

$loop = Factory::create();

$readable = new ReadableResourceStream(STDIN, $loop);
$writable = new WritableResourceStream(STDOUT, $loop);

$readable->on('data', function ($chunk) use ($readable, $writable, $loop) {
    
    $writable->write($chunk);
    $readable->pause();

    $loop->addTimer(2, function () use ($readable) {
        $readable->resume();
    });

});

/**
 * Alternative
 */
$readable->pipe($writable);

$readable->on('end', function () {
    echo "Finished\n";
});


$loop->run();