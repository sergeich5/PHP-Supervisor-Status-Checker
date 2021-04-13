<?php


namespace Sergeich5\SupervisorStatusChecker\Callback;


abstract class CallbackHandler implements CallbackHandlerInterface
{
    function onBeforeTick() {}

    function onAfterTick() {}

    function onFatal(string $processName) {}

    function onBackoff(string $processName) {}

    function onRunning(string $processName) {}

    function onStarting(string $processName) {}

    function onStopped(string $processName) {}

    function onUnknown(string $processName, string $status) {}
}
