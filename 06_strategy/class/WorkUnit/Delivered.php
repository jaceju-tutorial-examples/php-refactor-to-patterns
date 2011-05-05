<?php

class WorkUnit_Delivered extends WorkUnit_Abstract
{
    public function handle($queue)
    {
        $order = new Model_Order($this->_task->getDao());
        $order->bind($queue['orderNumber']);
        $order->deliverNumber = $queue['deliverNumber'];
        $order->orderStatus = Model_Order::DELIVERED;
        $order->save();

        $this->_task->addDebugInfo('Status ' . $order->orderStatus, $queue['orderNumber']);

        // 寄送出貨通知
        $this->_task->getMailer()->setSubject('訂單 ' . $order->orderNumber . ' 出貨通知');
        $this->_task->getMailer()->setBody('出貨通知內容');
        $this->_task->getMailer()->setFrom('service@company.com');
        $this->_task->getMailer()->addAddress($order->receiverEmail);
        $this->_task->getMailer()->send();
    }
}