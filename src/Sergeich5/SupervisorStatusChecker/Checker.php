<?php

namespace Sergeich5\SupervisorStatusChecker;

use Sergeich5\SupervisorStatusChecker\Callback\CallbackHandler;
use Sergeich5\SupervisorStatusChecker\Enums\Statuses;

class Checker
{
    /* @var int $delay */
    private $delay;

    /* @var CallbackHandler $callback */
    private $callback;

    /* @var bool $onChangeOnly */
    private $onChangeOnly;

    /* @var array $processes */
    private $processes;

    /* @var bool $debug */
    private $debug;

    function __construct(CallbackHandler $callback, int $delaySeconds = 5, bool $onChangeOnly = true, bool $debug = false)
    {
        $this->callback = $callback;
        $this->delay = $delaySeconds;
        $this->onChangeOnly = $onChangeOnly;
        $this->debug = $debug;

        $this->processes = array();
    }

    /* @return void */
    function checkOnce()
    {
        $this->logger('Executing bash command');
        $results = [];
        exec("supervisorctl status | awk '{print $1, $2}'", $results);

        $this->logger(sprintf('Got %d results', count($results)));

        foreach ($results as $result) {
            $this->logger(sprintf('Working on string %s', $result));

            $processes = explode(" ", $result);
            $this->logger(sprintf('Process %s with status %s', $processes[0], $processes[1]));

            switch ($processes[1]) {
                case Statuses::FATAL:
                    $status = Statuses::FATAL_INT;
                    break;
                case Statuses::RUNNING:
                    $status = Statuses::RUNNING_INT;
                    break;
                case Statuses::STARTING:
                    $status = Statuses::STARTING_INT;
                    break;
                case Statuses::BACKOFF:
                    $status = Statuses::BACKOFF_INT;
                    break;
                case Statuses::STOPPED:
                    $status = Statuses::STOPPED_INT;
                    break;
                default:
                    $this->logger(sprintf('Unknown status %s', $processes[1]));
            }

            if (isset($status))
                $this->processStatus($processes[0], $status);
        }
    }

    /* @return void */
    function checkLoop()
    {
        $this->logger('Checking in loop now');

        while (true) {
            $this->logger('Check loop tick');
            $this->callback->onBeforeTick();

            $this->checkOnce();

            $this->callback->onAfterTick();
            sleep($this->delay);
        }
    }

    /* @return void */
    private function processStatus(string $processName, int $status)
    {
        $this->logger(sprintf('Processing status of %s with status %s', $processName, $status));

        if ($this->onChangeOnly) {
            if ($this->isChanged($processName, $status)) {
                $this->setNewStatus($processName, $status);
                $this->callback($processName, $status);
            }
        }
        else
            $this->callback($processName, $status);
    }

    /* @return void */
    private function callback(string $processName, int $status)
    {
        $this->logger(sprintf('Sending callback of %s to %s status', $processName, $status));

        switch ($status) {
            case Statuses::FATAL_INT:
                $this->callback->onFatal($processName);
                break;
            case Statuses::BACKOFF_INT:
                $this->callback->onBackoff($processName);
                break;
            case Statuses::STARTING_INT:
                $this->callback->onStarting($processName);
                break;
            case Statuses::RUNNING_INT:
                $this->callback->onRunning($processName);
                break;
            case Statuses::STOPPED_INT:
                $this->callback->onStopped($processName);
                break;
        }
    }

    /* @return bool */
    private function isChanged(string $processName, int $status) : bool
    {
        $changed = (!isset($this->processes[md5($processName)]) || $this->processes[md5($processName)] != $status);

        $this->logger(sprintf('Checking is status of %s changed from %s: %b', $processName, $status, $changed));

        return $changed;
    }

    /* @return void */
    private function setNewStatus(string $processName, int $status)
    {
        $this->logger(sprintf('Setting status of %s to %s', $processName, $status));
        $this->processes[md5($processName)] = $status;
    }

    /* @return void */
    private function logger(string $msg)
    {
        if ($this->debug)
            echo sprintf('[%s]: %s', date('M d H:i:s'), $msg) . PHP_EOL;
    }
}
