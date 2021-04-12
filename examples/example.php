<?php

require_once __DIR__ . '/../vendor/autoload.php';

$callback = new MyCallbackHandler();

$loop = new \Sergeich5\SupervisorStatusChecker\Checker(
    $callback,
    5
);
$loop->checkLoop();

class MyCallbackHandler extends \Sergeich5\SupervisorStatusChecker\Callback\CallbackHandler
{
    function onFatal(string $processName, string $comment)
    {
        echo sprintf('Got fatal on proc %s', $processName);

        // YOUR LOGIC HERE
    }
}
