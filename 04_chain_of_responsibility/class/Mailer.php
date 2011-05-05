<?php

class Mailer
{

    protected $_subject = '';
    protected $_body = '';
    protected $_from = '';
    protected $_addresses = array();

    public function setSubject($subject)
    {
        $this->_subject = $subject;
    }

    public function setBody($body)
    {
        $this->_body = $body;
    }

    public function setFrom($from)
    {
        $this->_from = $from;
    }

    public function addAddress($address)
    {
        $this->_addresses[] = $address;
    }

    public function send()
    {

    }

}
