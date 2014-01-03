<?php
/**
 * 路由类
 *
 * @version 1.0
 * @author chuanwen.chen
 */
class XF_Router
{
	// 默认 Controller、Action
	private static $controller = 'Index';

	private static $action = 'index';

    /**
     * 根据请求 uri 获取 Controller Action
     *
     * @return array list($controller, $action)
     */
	public static function getControllerAction()
	{
		$uri = self::getURI();

		if(empty($uri) || $uri === '/')
		{
			return array('controller' => self::$controller . 'Controller', 'action' => self::$action . 'Action');
		}

		$uri = trim($uri, '/');
        $uriArray = explode('/', $uri);

        if(count($uriArray) !== 2)
        {
            throw new XF_Exception('route failed. uri is empty.');
        }

		$controller = $uriArray[0] ? ucfirst($uriArray[0]) : self::$controller;
		$action = $uriArray[1] ? $uriArray[1] : self::$action;

		if(($controller != self::$controller) || ($action != self::$action))
		{
			self::$controller = $controller;
			self::$action = $action;
		}

		return array('controller' => $controller . 'Controller', 'action' => $action . 'Action');
	}

	public static function getControllerName()
	{
		return self::$controller;
	}

	public static function getActionName()
	{
		return self::$action;
	}

    /**
     * 获取 uri
     *
     * @return string uri
     */
	public static function getURI()
	{
		$uri = $_SERVER['REQUEST_URI'];

        if($pos = strpos($uri, '?'))
        {
            $uri = substr($uri, 0, $pos);
        }

		if($uri[0] !== '/')
        {
            throw new XF_Exception('uri failed.');
		}

		// 控制 url 的格式和长度(1 - 20 个字符)，以防止恶意用户拼 uri 进行攻击
		if(!preg_match('/([\/a-zA-Z-_0-9]{1,20})/', $uri))
		{
			throw new XF_Exception('uri is failed.');
		}

		return $uri;
	}
}
