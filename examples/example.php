<?php

require_once __DIR__ . '/../vendor/autoload.php';

class MyCallbackHandler extends \Sergeich5\SupervisorStatusChecker\Callback\CallbackHandler
{
    function onFatal(string $processName)
    {
        echo sprintf('Got fatal on proc %s', $processName) . PHP_EOL;

        // YOUR LOGIC HERE
    }

    function onRunning(string $processName)
    {
        echo sprintf('Got running on proc %s', $processName) . PHP_EOL;

        // YOUR LOGIC HERE
    }

    function onStarting(string $processName)
    {
        echo sprintf('Got starting on proc %s', $processName) . PHP_EOL;

        // YOUR LOGIC HERE
    }

    function onBackoff(string $processName)
    {
        echo sprintf('Got backoff on proc %s', $processName) . PHP_EOL;

        // YOUR LOGIC HERE
    }

    function onStopped(string $processName)
    {
        echo sprintf('Got backoff on proc %s', $processName) . PHP_EOL;

        // YOUR LOGIC HERE
    }
}

$loop = new \Sergeich5\SupervisorStatusChecker\Checker(
    new MyCallbackHandler(),
    5,
    true,
    false
);
$loop->checkLoop();
