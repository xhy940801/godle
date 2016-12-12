<?php

class CoreException extends Exception
{
	private $debugMessage;

	public function __construct($code, $message = '', $debugMessage = '', $previous = NULL)
	{
		parent::__construct($debugMessage, $code, $previous);
		$this->debugMessage = $debugMessage;
	}

	public function getDebugMessage()
	{
		return $this->debugMessage;
	}
}

class PageNotFoundException extends CoreException
{
	public function __construct($debugMessage, $previous = NULL)
	{
		parent::__construct(404, 'page not found.', $debugMessage, $previous);
	}
}

class ClassNotFoundException extends PageNotFoundException
{
	public function __construct($classname, $previous = NULL)
	{
		parent::__construct('Class ' . $classname . ' not found.', $previous);
	}
}

class MethodNotFoundException extends PageNotFoundException
{
	public function __construct($classname, $methodname, $previous = NULL)
	{
		parent::__construct('Method ' . $methodname . ' not found in class ' . $classname . '.', $previous);
	}
}
