<?php

class App
{
    static private $_includedFileMap = array(__FILE__ => true);

    static public function import($className, $module, $basePath = __APP_DIR__, $prefix = '.class.php')
    {
        $path = __ROOT__ . DIRECTORY_SEPARATOR . $basePath . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $className . $prefix;
        if(isset(self::$_includedFileMap[$path]))
            return;
        require($path);
        self::$_includedFileMap[$path] = true;
    }

    static public function uses($className, $module, $basePath = __APP_DIR__, $prefix = '.class.php')
    {
        $path = __ROOT__ . DIRECTORY_SEPARATOR . $basePath . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . $className . $prefix;
        self::$_includedFileMap[$path] = true;
        return $path;
    }

    static public function getConf()
    {
        $config = require(__ROOT__ . DIRECTORY_SEPARATOR . __APP_DIR__ . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . 'conf.php');
        if (empty($config))
            $config = array();
        $defaultConfig = require(__ROOT__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'godle' . DIRECTORY_SEPARATOR . 'conf.php');
        return array_merge($defaultConfig, $config);
    }

    static public function getDataPath($type, $classname, $name)
    {
        return __ROOT__ . DIRECTORY_SEPARATOR . __DATA_DIR__ . DIRECTORY_SEPARATOR . $type . '.' . $classname . '.' . $name;
    }

    static public function getCachePath($type, $classname, $name)
    {
        return __ROOT__ . DIRECTORY_SEPARATOR . __CACHE_DIR__ . DIRECTORY_SEPARATOR . $type . '.' . $classname . '.' . $name;
    }

    static public function dispacheError($e, $dispacherArr, $conf)
    {
        $pageControllerName = $conf['defaultController'] . 'Controller';
        $pageController = new $pageControllerName;
        switch($e->getCode())
        {
        case 404:
            $pageController->_initController($conf['defaultController'], 'pageNotFound', $conf);
            $pageController->_doAction(array($e));
            break;
        default:
            $pageController->_initController($conf['defaultController'], 'systemError', $conf);
            $pageController->_doAction(array($e));
            break;
        }
    }

    static public function execute($dispacherArr, $conf)
    {
        $controllerName = $dispacherArr['controller'] . 'Controller';
        if (!class_exists($controllerName))
            throw new ClassNotFoundException($controllerName);
        $controller = new $controllerName();
        $controller->_initController($dispacherArr['controller'], $dispacherArr['action'], $conf);
        $controller->_doAction(array_slice($urlArr, 3));
    }

    static public function dispacher($url, $conf)
    {
        $urlArr = explode('/', $url);

        $dispacherArr = array('controller' => $conf['defaultController'], 'action' => $conf['defaultAction']);

        if(!empty($urlArr[1]))
            $dispacherArr['controller'] = $urlArr[1];
        if(!empty($urlArr[2]))
            $dispacherArr['action'] = $urlArr[2];

        try
        {
            App::execute($dispacherArr, $conf);
        }
        catch (CoreException $e)
        {
            App::dispacheError($e, $dispacherArr, $conf);
        }
    }
}
