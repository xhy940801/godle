<?php

class Controller
{
	public $context;

	protected $_helpers = array();
	protected $_plugins = array();
	protected $layout;

	protected $_config = array();

	private $_viewName;
	private $_viewFields = array();

	public $param;

	public function _initController($controller, $action, $config)
	{
		$this->param = array(
			'controller' => $controller,
			'action' => $action
			);
		$this->_viewName = $action;
		$this->_config = $config;
		$this->layout = $config['defaultLayout'];

		$this->initPlugins($this->_plugins);
	}

	public function _doAction($actionParams)
	{
		$this->_beforeAction();
		call_user_func_array(array($this, $this->param['action']), $actionParams);
		$this->_afterAction();
		$this->_render();
	}

	protected function render($ctpname)
	{
		$this->_viewName = $ctpname;
	}

	protected function initPlugins($plugins)
	{
		foreach ($plugins as $plugin)
		{
			App::import($plugin, $plugin, $this->_config['pluginPath']);
			$this->$plugin = new $plugin();
		}
	}

	protected function set($key, $value)
	{
		$this->_viewFields[$key] = $value;
	}

	protected function isPost()
	{
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}

	protected function post($name = null, $default = null)
	{
		if(isset($name))
        {
            if(isset($_POST[$name]))
			    return $_POST[$name];
            else
                return $default;
        }
		return $_POST;
	}

	protected function isGet()
	{
		return $_SERVER['REQUEST_METHOD'] === 'GET';
	}

	protected function get($name = null, $default = null)
	{
		if(isset($name))
        {
            if(isset($_GET[$name]))
			    return $_GET[$name];
            else
                return $default;
        }
		return $_GET;
	}

    protected function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

	protected function redirect($url, $parmas = array())
	{
		$realUrl;
		if(is_string($url))
			$realUrl = $url;
		else
		{
			$realUrl = __HOST_URL__ . '/' . $url['controller'] . '/' . $url['action'];
			foreach ($parmas as $value)
				$realUrl .= ('/' . $value);
		}
		header('Location: ' . $realUrl);
	}

	protected function _beforeAction()
	{

	}

	protected function _afterAction()
	{

	}

	protected function _beforeRender()
	{

	}

	protected function _afterRender()
	{

	}

	protected function _finalize()
	{

	}

	public function _render()
	{
		$this->_beforeRender();

		App::import('View', 'View', 'lib' . DIRECTORY_SEPARATOR . 'godle');
		$view = new View($this->_helpers, $this->_viewFields, $this->layout, $this->_viewName, $this->param['controller']);
		$view->render();

		$this->_afterRender();
	}
}
