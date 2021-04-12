<?php


namespace Sergeich5\SupervisorStatusChecker\Enums;


abstract class Statuses
{
    const FATAL_INT = 1;
    const RUNNING_INT = 2;
    const STARTING_INT = 3;
    const BACKOFF_INT = 4;
    const STOPPED_INT = 5;

    const FATAL = "FATAL";
    const RUNNING = "RUNNING";
    const STARTING = "STARTING";
    const BACKOFF = "BACKOFF";
    const STOPPED = "STOPPED";
}
