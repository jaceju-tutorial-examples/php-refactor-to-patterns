<?php

class WorkUnit_Invoice extends WorkUnit_Abstract
{
    protected function _check($queue)
    {
        return (Model_Order::INVOICE === $queue['orderStatus']);
    }

    protected function _handle($queue)
    {
        $order = new Model_Order($this->_task->getDao());
        $order->bind($queue['orderNumber']);
        $order->invoiceNumber = $queue['invoiceNumber'];
        $order->orderStatus = Model_Order::INVOICE;
        $order->save();

        $this->_task->addDebugInfo('Status ' . $order->orderStatus, $queue['orderNumber']);

        // 寄送發票通知
        $this->_task->getMailer()->setSubject('訂單 ' . $order->orderNumber . ' 發票通知');
        $this->_task->getMailer()->setBody('發票通知內容');
        $this->_task->getMailer()->setFrom('service@company.com');
        $this->_task->getMailer()->addAddress($order->shopperEmail);
        $this->_task->getMailer()->send();
    }
}