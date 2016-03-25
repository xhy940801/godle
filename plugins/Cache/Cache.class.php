<?php

class Cache
{
    private $hasChange = false;
    private $dataPath;
    private $datas = array();

    public function __construct()
    {
        $this->dataPath = App::getCachePath('plugin', 'Cache', 'conf');
        if(!file_exists($this->dataPath))
            return;
        $content = file_get_contents($this->dataPath);
        if(empty($content))
            return;
        $this->datas = unserialize($content);
    }

    public function set($name, $value)
    {
        $this->datas[$name] = $value;
        $this->hasChange = true;
    }

    public function get($name, $default = null)
    {
        if(isset($this->datas[$name]))
            return $this->datas[$name];
        return $default;
    }

    public function clear()
    {
        $this->datas = array();
        $this->hasChange = true;
    }

    public function setall($datas)
    {
        $this->datas = $datas;
        $this->hasChange = true;
    }

    public function getall()
    {
        return $this->datas;
    }

    public function flush()
    {
        if($this->hasChange)
        {
            echo "\n???";
            $content = serialize($this->datas);
            file_put_contents($this->dataPath, $content);
        }
    }
}
