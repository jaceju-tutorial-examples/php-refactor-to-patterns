<?php

class WorkUnit_Invoice extends WorkUnit_Abstract
{
    protected function _setOrderData($queue)
    {
        $this->_order->invoiceNumber = $queue['invoiceNumber'];
        $this->_order->orderStatus = Model_Order::INVOICE;
    }

    protected function _sendMail()
    {
        // 寄送發票通知
        $this->_task->getMailer()->setSubject('訂單 ' . $this->_order->orderNumber . ' 發票通知');
        $this->_task->getMailer()->setBody('發票通知內容');
        $this->_task->getMailer()->setFrom('service@company.com');
        $this->_task->getMailer()->addAddress($this->_order->shopperEmail);
        $this->_task->getMailer()->send();
    }
}