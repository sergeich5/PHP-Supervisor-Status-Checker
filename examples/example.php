<?php

require_once __DIR__ . '/../vendor/autoload.php';

/* See ../src/Sergeich5/SupervisorStatusChecker/Callback/CallbackHandlerInterface.php */

class MyCallbackHandler extends \Sergeich5\SupervisorStatusChecker\Callback\CallbackHandler
{
    function onBeforeTick()
    {
        echo 'onBeforeTick' . PHP_EOL;

        // YOUR LOGIC HERE
    }

    function onAfterTick()
    {
        echo 'onAfterTick' . PHP_EOL;

        // YOUR LOGIC HERE
    }

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
