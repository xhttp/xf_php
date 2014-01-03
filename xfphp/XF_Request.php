<?php
/**
 * 获取输入统一入口
 *
 * @version 1.0
 * @author chuanwen.chen
 */
class XF_Request
{
	private $getdata;

	private $postdata;

	private $filedata;

	private $cookiedata;

	private static $_instance;

	private function __construct()
    {
        $this->getdata    = self::formatData($_GET);
        $this->postdata   = self::formatData($_POST);
        $this->filedata   = self::formatData($_FILES);
       	$this->cookiedata = self::formatData($_COOKIE);

		if(!$GLOBALS['Debug']) unset($_GET, $_POST, $_FILES, $_COOKIE, $_REQUEST);
		unset($HTTP_ENV_VARS, $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_POST_FILES, $HTTP_COOKIE_VARS);
    }
    
	public static function getInstance()
	{
		if(!(self::$_instance instanceof self))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}
    
	public function getNum($key)
	{
		return $this->toNum($this->getdata[$key]);
	}
	
	public function postNum($key)
	{
		return $this->toNum($this->postdata[$key]);
	}
	
	public function getString($key, $isfilter = true)
	{
		if($isfilter)
		{
			return $this->filterString($this->toString($this->getdata[$key]));
		}
		else
		{
			return $this->getdata[$key];
		}
	}
	
	public function postString($key, $isfilter = true)
	{
		if($isfilter)
		{
			return $this->filterString($this->toString($this->postdata[$key]));
		}
		else
		{
			return $this->postdata[$key];
		}
	}
	
	public function getCookieString($key, $isfilter = true)
	{
		if($isfilter)
		{
			return $this->filterString($this->toString($this->cookiedata[$key]));
		}
		else
		{
			return $this->cookiedata[$key];
		}
	}
	
	private	function formatData($data)
	{
		$result = array();
        reset($data);
        while(list($key, $value) = each($data))
        {
            $result[$key] = trim($value);
        }
        return $result;
	}

	private function toNum($num)
	{
		if(is_numeric($num))
		{
			return intval($num);
		}
		else
		{
			return false;
		}
	}

	private function toString($str)
	{
		if(is_string($str))
		{
			return strval($str);
		}
		else
		{
			return false;
		}
	}

	private function filterString($string)
	{
		if($string === NULL)
		{
			return false;
		}
		return htmlspecialchars($string);
	}
}
