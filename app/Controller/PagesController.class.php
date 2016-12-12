<?php

class PagesController extends AppController
{
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
}
