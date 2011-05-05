<?php

class Model_Order extends Model
{
    const PAID = 1;
    const INVOICE = 2;
    const DELIVERED = 3;
    const CLOSED = 4;

    protected $_table = 'orders';

    protected $_primary = 'orderNumber';
}