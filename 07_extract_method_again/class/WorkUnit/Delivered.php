<?php

class WorkUnit_Delivered extends WorkUnit_Abstract
{
    protected $_order = NULL;

    public function handle($queue)
    {
        $this->_buildOrder($queue);
        $this->_setOrderData($queue);
        $this->_updateOrder($queue);
        $this->_addDebugInfo($queue);
        $this->_sendMail();
    }

    protected function _buildOrder($queue)
    {
        $this->_order = new Model_Order($this->_task->getDao());
        $this->_order->bind($queue['orderNumber']);
    }

    protected function _setOrderData($queue)
    {
        $this->_order->deliverNumber = $queue['deliverNumber'];
        $this->_order->orderStatus = Model_Order::DELIVERED;
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
        $this->_task->getMailer()->setSubject('訂單 ' . $this->_order->orderNumber . ' 出貨通知');
        $this->_task->getMailer()->setBody('出貨通知內容');
        $this->_task->getMailer()->setFrom('service@company.com');
        $this->_task->getMailer()->addAddress($this->_order->receiverEmail);
        $this->_task->getMailer()->send();
    }
}