<?php

class Task_Queue
{
    protected $_dao = null;

    public function setDao(Dao $dao)
    {
        $this->_dao = $dao;
    }

    public function getDao()
    {
        return $this->_dao;
    }

    protected $_mailer = null;

    public function setMailer(Mailer $mailer)
    {
        $this->_mailer = $mailer;
    }

    public function getMailer()
    {
        return $this->_mailer;
    }

    protected $_debugInfo = array();

    public function addDebugInfo($key, $message)
    {
        if (!array_key_exists($key, $this->_debugInfo)) {
            $this->_debugInfo[$key] = array();
        }
        $this->_debugInfo[$key][] = $message;
    }

    public function getDebugInfo()
    {
        return $this->_debugInfo;
    }

    public function run()
    {
        $paidWorkUnit = new WorkUnit_Paid($this);
        $invoiceWorkUnit = new WorkUnit_Invoice($this);
        $deliveredWorkUnit = new WorkUnit_Delivered($this);
        $closedWorkUnit = new WorkUnit_Closed($this);

        $paidWorkUnit->setNext($invoiceWorkUnit)
                     ->setNext($deliveredWorkUnit)
                     ->setNext($closedWorkUnit);

        $queues = $this->_dao->fetchAll('queues');

        foreach ($queues as $queueId => $queue) {

            $paidWorkUnit->handle($queue);

            // 刪除舊的 Queue
            $where = array(
                'queueId' => $queueId,
            );
            $this->_dao->delete('queues', $where);
        }
    }

}