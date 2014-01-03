<?php
/**
 * XF 框架统一入口
 *
 * @version 1.0
 * @author chuanwen.chen
 */
class XF_Application
{
	/**
	 * 系统参数设置
	 */
	public function __construct($configFile)
	{
		// 导入全局配置文件
		if(empty($configFile) || !file_exists($configFile) || !is_readable($configFile))
		{
			throw new XF_Exception($configFile . ' not exist.');
		}

		include($configFile);

		if(empty($GLOBALS))
		{
			throw new XF_Exception('globals config is empty.');
		}

		// 检查是否开启全站关闭开关
		if($GLOBALS['Shutdown'])
		{
			$this->shutdown();
		}

		// 导入 XF 基础类文件
		$this->importXFCore();

		set_magic_quotes_runtime(0);
		date_default_timezone_set($GLOBALS['TimeZone']);

		if($GLOBALS['Debug'])
		{
			error_reporting(E_ALL ^ E_NOTICE);
			@ini_set('display_errors', 'On');
		}
		else
		{
			error_reporting(0);
			@ini_set('display_errors', 'Off');
		}
	}

	/**
	 * 导入 XF 框架核心文件
	 */
	private function importXFCore()
	{
		include(XF_DIR . 'XF_Util.php');
		include(XF_DIR . 'XF_Router.php');
		include(XF_DIR . 'XF_Request.php');
		include(XF_DIR . 'XF_Response.php');
		include(XF_DIR . 'XF_Controller.php');
	}

	/**
	 * application 入口方法
	 */
	public function run()
	{
		$this->dispatch();
	}

	/**
	 * 路由分发
	 */
	private function dispatch()
	{
		$controller = $action = '';

		$routs = XF_Router::getControllerAction();
		$controller = $routs['controller'];
		$action = $routs['action'];

		if(empty($controller) || empty($action))
		{
			throw new XF_Exception('controller or action is empty.');
		}

		// 导入控制器文件
		$controllerFile = APP_CONTROLLER_DIR . $controller . '.php';
		if(!file_exists($controllerFile) || !is_readable($controllerFile))
		{
				throw new XF_Exception('controller file ' . $controllerFile . ' not exist.');
		}

		include($controllerFile);

		if(!class_exists($controller, false))
		{
			throw new XF_Exception('controller class ' . $controller . ' not exist.');
		}

		// 实例化 controller
		$object = new $controller;

		if (!method_exists($object, $action))
		{
			throw new XF_Exception('controller class method ' . $controller . '->' . $action() . ' not exist.');
		}

		// 执行 action
		return $object->$action();
	}

	/**
	 * 关闭全站
	 */
	private function shutdown()
	{
		exit();
	}

	public function getConfig()
	{
		return $GLOBALS;
	}
}
