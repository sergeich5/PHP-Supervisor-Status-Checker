<?php


namespace Sergeich5\SupervisorStatusChecker\Callback;


abstract class CallbackHandler implements CallbackHandlerInterface
{
     function onFatal(string $processName, string $comment) {}
 }
