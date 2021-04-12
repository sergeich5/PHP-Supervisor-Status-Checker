<?php


namespace Sergeich5\SupervisorStatusChecker\Callback;


abstract class CallbackHandler implements CallbackHandlerInterface
{
    function onFatal(string $processName) {}

    function onBackoff(string $processName) {}

    function onRunning(string $processName) {}

    function onStarting(string $processName) {}

    function onStopped(string $processName) {}
}
