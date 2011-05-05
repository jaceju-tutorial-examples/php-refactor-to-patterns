<?php

class WorkUnit_Closed extends WorkUnit_Abstract
{
    protected function _setOrderData($queue)
    {
        $this->_order->orderStatus = Model_Order::CLOSED;
    }
}