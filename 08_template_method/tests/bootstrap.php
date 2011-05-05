<?php
define('__ROOT__', __DIR__ . '/..');

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(__ROOT__ . '/class'),
    realpath(__DIR__ . '/include'),
    get_include_path(),
)));

function autoload($className)
{
    $className = str_replace('_', '/', $className);
    require_once "$className.php";
}

spl_autoload_register('autoload');

define('ORDER_STATUS_PAID', 1);
define('ORDER_STATUS_INVOICE', 2);
define('ORDER_STATUS_DELIVERED', 3);
define('ORDER_STATUS_CLOSED', 4);