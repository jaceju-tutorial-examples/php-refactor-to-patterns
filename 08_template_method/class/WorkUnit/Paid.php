<?php

class WorkUnit_Paid extends WorkUnit_Abstract
{
    protected function _setOrderData($queue)
    {
        $this->_order->orderStatus = Model_Order::PAID;
    }
}