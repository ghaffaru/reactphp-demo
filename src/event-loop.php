<?php

use React\EventLoop\Factory;
use React\EventLoop\TimerInterface;

require '../vendor/autoload.php';

$loop = Factory::create();

// setTimer equivalent
$loop->addTimer(3, function () {
    echo "After timer\n";
});

echo "Before Timer\n";

// setInterval equivalent
$counter = 0;
$loop->addPeriodicTimer(1, function (TimerInterface $timer) use (&$counter, $loop) {
    $counter ++;
    if ($counter == 5) {
        $loop->cancelTimer($timer);
    }
    echo "Hello\n";
});

$loop->run();




