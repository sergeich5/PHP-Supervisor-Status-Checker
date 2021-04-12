<?php

namespace Sergeich5\SupervisorStatusChecker;

use Sergeich5\SupervisorStatusChecker\Callback\CallbackHandler;

class Checker
{
    private $delay;
    private $callback;

    function __construct(CallbackHandler $callback, int $delaySeconds = 5)
    {
        $this->callback = $callback;
        $this->delay = $delaySeconds;
    }

    function checkOnce()
    {
        $results = [];
        exec('supervisorctl status all | grep FATAL', $results);

        foreach ($results as $result) {
            $res = explode("FATAL", $result);
            foreach ($res as $k => $v)
                $this->callback->onFatal(trim($res[0]), trim($res[1]));
        }
    }

    function checkLoop()
    {
        while (true) {
            $this->checkOnce();
            sleep($this->delay);
        }
    }
}
