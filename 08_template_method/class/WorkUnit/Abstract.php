<?php

abstract class WorkUnit_Abstract
{
    protected $_task = NULL;

    public function __construct(Task_Queue $task)
    {
        $this->_task = $task;
    }

    protected $_order = NULL;

    public function handle($queue)
    {
        $this->_buildOrder($queue);
        $this->_setOrderData($queue);
        $this->_updateOrder($queue);
        $this->_addDebugInfo($queue);
        $this->_sendMail();
        $this->_deleteQueue($queue);
    }

    protected function _buildOrder($queue)
    {
        $this->_order = new Model_Order($this->_task->getDao());
        $this->_order->bind($queue['orderNumber']);
    }

    protected function _setOrderData($queue)
    {
    }

    protected function _updateOrder($queue)
    {
        $this->_order->save();
    }

    protected function _addDebugInfo($queue)
    {
        $this->_task->addDebugInfo('Status ' . $this->_order->orderStatus, $queue['orderNumber']);
    }

    protected function _sendMail()
    {
    }

    protected function _deleteQueue($queue)
    {
        // 刪除舊的 Queue
        $where = array(
            'queueId' => $queue['queueId'],
        );
        $this->_task->getDao()->delete('queues', $where);
    }
}