<?php

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(__DIR__ . '/../library'),
    get_include_path(),
)));

function ZendTest_Autoloader($class)
{
    $class = ltrim($class, '\\');

    if (!preg_match('#^(Zend(Test)?|PHPUnit)(\\\\|_)#', $class)) {
        return false;
    }

    // $segments = explode('\\', $class); // preg_split('#\\\\|_#', $class);//
    $segments = preg_split('#[\\\\_]#', $class); // preg_split('#\\\\|_#', $class);//
    $ns       = array_shift($segments);
    if ($ns=='PHPUnit') return false;

    $nsDbDocument = $segments[0] . '\\' . $segments[1];

    switch ($ns) {
        case 'Zend':
            if ($nsDbDocument=='Db\\Document') {
                $file = dirname(__DIR__) . '/library/Zend/Db/Document/';
                array_shift($segments);
                array_shift($segments);
                break;
            }
            $file = 'Zend/';
            break;
        case 'ZendTest':
            $file = __DIR__ . '/Zend/';
            break;
        default:
            $file = false;
            break;
    }

    if ($file) {
        $file .= implode('/', $segments) . '.php';
        if (file_exists($file)) {
            return include_once $file;
        }
    }
    return false;
}
spl_autoload_register('ZendTest_Autoloader', true, true);

/* REDIS */
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_ENABLED', true);
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_HOST', '127.0.0.1');
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_REDIS_PORT', 6379);

/* MONGO */
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_ENABLED', true);
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_HOST', '127.0.0.1');
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_PORT', 27017);
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_MONGO_DATABASE', 'dbtest');

/* COUCH */
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_ENABLED', true);
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_HOST', '127.0.0.1');
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_PORT', 5984);
define('TESTS_ZEND_DB_DOCUMENT_ADAPTER_COUCH_DATABASE', 'dbtest');

