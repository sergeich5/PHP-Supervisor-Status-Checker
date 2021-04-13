<?php

namespace Sergeich5\SupervisorStatusChecker\Callback;

interface CallbackHandlerInterface
{
    /**
     * Triggers before supervisor check in loop started
     *
     * @return void
     */
    function onBeforeTick();

    /**
     * Triggers after supervisor check in loop finished
     *
     * @return void
     */
    function onAfterTick();

    /**
     * Triggers when supervisor process has FATAL status
     *
     * @return void
     */
    function onFatal(string $processName);

    /**
     * Triggers when supervisor process has BACKOFF status
     *
     * @return void
     */
    function onBackoff(string $processName);

    /**
     * Triggers when supervisor process has RUNNING status
     *
     * @return void
     */
    function onRunning(string $processName);

    /**
     * Triggers when supervisor process has STARTING status
     *
     * @return void
     */
    function onStarting(string $processName);

    /**
     * Triggers when supervisor process has STOPPED status
     *
     * @return void
     */
    function onStopped(string $processName);

    /**
     * Triggers when supervisor process has unknown status
     *
     * @return void
     */
    function onUnknown(string $processName, string $status);
}
