<?php

class WorkUnit_Closed extends WorkUnit_Abstract
{
    protected function _check($queue)
    {
        return (Model_Order::CLOSED === $queue['orderStatus']);
    }

    protected function _handle($queue)
    {
        $order = new Model_Order($this->_task->getDao());
        $order->bind($queue['orderNumber']);
        $order->orderStatus = Model_Order::CLOSED;
        $order->save();

        $this->_task->addDebugInfo('Status ' . $order->orderStatus, $queue['orderNumber']);
    }
}