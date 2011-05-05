<?php

class WorkUnit_Delivered extends WorkUnit_Abstract
{
    protected function _setOrderData($queue)
    {
        $this->_order->deliverNumber = $queue['deliverNumber'];
        $this->_order->orderStatus = Model_Order::DELIVERED;
    }

    protected function _sendMail()
    {
        $this->_task->getMailer()->setSubject('訂單 ' . $this->_order->orderNumber . ' 出貨通知');
        $this->_task->getMailer()->setBody('出貨通知內容');
        $this->_task->getMailer()->setFrom('service@company.com');
        $this->_task->getMailer()->addAddress($this->_order->receiverEmail);
        $this->_task->getMailer()->send();
    }
}