<?php
function __autoload($className)
{
    if(substr($className, -10) == 'Controller')
        App::import($className, 'Controller');
    else
        throw new Exception('Class: ' . $className . ' not found!');
}

function exception_error_handler($errno, $errstr, $errfile, $errline )
{
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler("exception_error_handler");
