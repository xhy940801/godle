<?php

class PagesController extends AppController
{
    public function index()
    {
    }

    public function pageNotFound($e)
    {
        header('HTTP/1.1 404 Not Found');
        if ($this->config('debugMode'))
            $this->set('message', $e->getDebugMessage());
        else
            $this->set('message', $e->getMessage());
        $this->render('404', 'empty');
    }

    public function systemError($e)
    {
        header('HTTP/1.1 500 Internal Server Error');
        if ($this->config('debugMode'))
            $this->set('message', $e->getDebugMessage());
        else
            $this->set('message', $e->getMessage());
        $this->render('500', 'empty');
    }

    public function unknowError($e)
    {
        header('HTTP/1.1 500 Internal Server Error');
        if ($this->config('debugMode'))
            $this->set('message', $e->getMessage());
        else
            $this->set('message', 'Unknow error.');
        $this->set('debug', $this->config('debugMode'));
        $this->set('e', $e);
        $this->render('500', 'empty');
    }
}
