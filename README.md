# Supervisor Status Checker

Simple tool to check supervisor's processes statuses. You can receive events on process FATAL error and, for example, send a notification to yourself.

## Installation

`composer require sergeich5/php-supervisor-status-checker`

## Usage

1) Create your own class and extend it from `\Sergeich5\SupervisorStatusChecker\Callback\CallbackHandler` or implement from `\Sergeich5\SupervisorStatusChecker\Callback\CallbackHandlerInterface`

```php
<?php

// MyCallbackHandler.php

class MyCallbackHandler extends \Sergeich5\SupervisorStatusChecker\Callback\CallbackHandler
{
    function onBeforeTick()
    {
        // YOUR LOGIC HERE
    }

    function onAfterTick()
    {
        // YOUR LOGIC HERE
    }
    
    function onFatal(string $processName)
    {
        // YOUR LOGIC HERE
    }

    function onRunning(string $processName)
    {
        // YOUR LOGIC HERE
    }

    function onStarting(string $processName)
    {
        // YOUR LOGIC HERE
    }

    function onBackoff(string $processName)
    {
        // YOUR LOGIC HERE
    }

    function onStopped(string $processName)
    {
        // YOUR LOGIC HERE
    }

    function onUnknown(string $processName, string $status)
    {
        // YOUR LOGIC HERE
    }
}
```

2) Implement necessary events and do your logic
   
3) Create an instance of `\Sergeich5\SupervisorStatusChecker\Checker` and provide an instance of `MyCallbackHandler`, checking delay in seconds, event logic and debug/no-debug mode

```php
$loop = new \Sergeich5\SupervisorStatusChecker\Checker(
    new MyCallbackHandler(),
    true,
    false
);
```

4) Call method `checkLoop(int DELAY_IN_SECONDS)` for automatically check

```php
$loop->checkLoop( int DELAY_IN_SECONDS );
```

or `checkOnce()` for one-time check

```php
$loop->checkOnce();
```
