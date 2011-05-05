<?php

abstract class WorkUnit_Abstract
{
    protected $_task = NULL;

    public function __construct(Task_Queue $task)
    {
        $this->_task = $task;
    }

    abstract public function handle($queue);
}