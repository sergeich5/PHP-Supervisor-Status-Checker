<?php

namespace Sergeich5\SupervisorStatusChecker\Callback;

interface CallbackHandlerInterface
{
    function onFatal(string $processName, string $comment);
}
