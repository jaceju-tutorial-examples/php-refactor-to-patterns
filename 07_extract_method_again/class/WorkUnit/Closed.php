<?php

class WorkUnit_Closed extends WorkUnit_Abstract
{
    protected $_order = NULL;
    
    public function handle($queue)
    {
        $this->_buildOrder($queue);
        $this->_setOrderData($queue);
        $this->_updateOrder($queue);
        $this->_addDebugInfo($queue);
    }

    protected function _buildOrder($queue)
    {
        $this->_order = new Model_Order($this->_task->getDao());
        $this->_order->bind($queue['orderNumber']);
    }

    protected function _setOrderData($queue)
    {
        $this->_order->orderStatus = Model_Order::CLOSED;
    }

    protected function _updateOrder($queue)
    {
        $this->_order->save();
    }

    protected function _addDebugInfo($queue)
    {
        $this->_task->addDebugInfo('Status ' . $this->_order->orderStatus, $queue['orderNumber']);
    }
}