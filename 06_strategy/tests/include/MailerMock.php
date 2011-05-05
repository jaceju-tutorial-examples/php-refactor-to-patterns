<?php

class MailerMock extends Mailer
{

    protected $_debugInfo = array();

    public function debug($key, $value)
    {
        $this->_debugInfo[$key] = $value;
    }

    public function getDebugInfo()
    {
        return $this->_debugInfo;
    }

    public function send()
    {
        $this->debug($this->_subject, array(
            'subject' => $this->_subject,
            'body' => $this->_body,
            'from' => $this->_from,
            'addresses' => $this->_addresses,
        ));
    }

}
