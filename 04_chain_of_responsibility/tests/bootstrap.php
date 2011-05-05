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
