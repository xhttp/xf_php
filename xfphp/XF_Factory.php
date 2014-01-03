<?php
/**
 * class 工厂创建器
 */
class XF_Factory
{
	private static $classArray = array();

	/**
	 * 创建一个实例
	 */	
	public static function create($className, $isSingle = true)
	{
		if($isSingle && isset(self::$classArray[$className]) && is_object(self::$classArray[$className]))
		{
			return self::$classArray[$className];
		}

		$array = explode("/", $className);
		$index = count($array) - 1;
		$class = $array[$index];

		if(!class_exists($class))
		{
			include_once($className.'.php');
		}

		$object = new $class;

		self::$classArray[$className] = $object;

		return $object;
	}
}
