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
        $queues = $this->_dao->fetchAll('queues');

        foreach ($queues as $queueId => $queue) {

            $workUnit = $this->_getWorkUnit($queue['orderStatus']);
            $workUnit->handle($queue);

            // 刪除舊的 Queue
            $where = array(
                'queueId' => $queueId,
            );
            $this->_dao->delete('queues', $where);
        }
    }

    protected static $_workUnitMap = array(
        Model_Order::PAID => 'WorkUnit_Paid',
        Model_Order::INVOICE => 'WorkUnit_Invoice',
        Model_Order::DELIVERED => 'WorkUnit_Delivered',
        Model_Order::CLOSED => 'WorkUnit_Closed',
    );

    protected function _getWorkUnit($orderStatus)
    {
        static $workUnits = array();
        if (!array_key_exists($orderStatus, $workUnits)) {
            $className = self::$_workUnitMap[$orderStatus];
            $workUnits[$orderStatus] = new $className($this);
        }
        return $workUnits[$orderStatus];
    }
}