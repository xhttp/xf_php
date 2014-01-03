<?php
class XF_Response
{
	/*
	private static $_instance;
    
	public static function getInstance()
	{
		if(!(self::$_instance instanceof self))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	*/

	public static function dump($value, $isStop = false)
	{
		var_dump($value);

		if($isStop)
		{
			exit();
		}
	}
}
