<?php

abstract class WorkUnit_Abstract
{
    protected $_task = NULL;

    public function __construct(Task_Queue $task)
    {
        $this->_task = $task;
    }

    /**
     * @var WorkUnit_Abstract
     */
    protected $_nextHandler = NULL;

    /**
     *
     * @param WorkUnit_Abstract $handler
     * @return WorkUnit_Abstract
     */
    public function setNext(WorkUnit_Abstract $handler)
    {
        $this->_nextHandler = $handler;
        return $this->_nextHandler;
    }

    public function handle($queue)
    {
        if ($this->_check($queue)) {
            $this->_handle($queue);
        } else {
            $this->_nextHandler->handle($queue);
        }
    }

    abstract protected function _check($queue);

    abstract protected function _handle($queue);
}