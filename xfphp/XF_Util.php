<?php
class XF_Util
{
    public static function xstripslashes($param)
    {
        if(is_array($param))
        {
            foreach ($param as $k => $v)
            {
                $param[$k] = self::xstripslashes($v);
            }
            return $param;
        }
        else
        {
            return stripslashes($param);
        }
    }

	public static function getClientIP()
	{
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown'))
		{
			$onlineip = getenv('HTTP_CLIENT_IP');
		}
		elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown'))
		{
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown'))
		{
			$onlineip = getenv('REMOTE_ADDR');
		}
		elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown'))
		{
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}

		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
		unset($onlineipmatches);

		return $onlineip;
	}

    public static function array2Json($array = array(), $_s = false)
    {
        $r = array();
        foreach((array) $array as $key => $val)
        {
            if(is_array($val))
            {
                $r[$key] = "\"$key\": " . self::array2Json($val, $_s);
            }
            else
            {
                if($_s && $key == '_s')
                {
                    $r[$key] = "\"$key\": " . $val;
                }
                else
                {
                    if(is_numeric($val))
                    {
                        $r[$key] = "\"$key\": " . $val;
                    }
                    else if(is_bool($val))
                    {
                        $r[$key] = "\"$key\": " . ($val ? 'true' : 'false');
                    }
                    else if(is_null($val))
                    {
                        $r[$key] = "\"$key\": null";
                    }
                    else
                    {
                        $r[$key] = "\"$key\": \"" . str_replace(array("\r\n", "\n", "\""), array("\\n", "\\n", "\\\""), $val) . '"';
                    }
                }
            }
        }
        return '{' . implode(',', $r) . '}';
    }

	public static function makeDir($dir)
	{
		$path = array();
		$dir = preg_replace("/\/*$/", "", $dir);
		while(!is_dir($dir) && strlen(str_replace("/", "", $dir)))
		{
			$path[] = $dir;
			$dir = preg_replace("/\/[\w-]+$/", "", $dir);
		}
		krsort($path);
		if (sizeof($path))
		{
			foreach($path as $key => $val)
			{
				@mkdir($val, 0777);
			}
		}
		return true;
	}

    public static function utf8Substr($string, $len = 0, $etc = '')
    {
        $str = $string;
        if($len == 0)
		{
            return $str;
        }
        $len *= 2;
        if(strlen($str) <= $len)
		{
            return $str;
        }

        for($i = 0; $i < $len; $i++)
        {
            $temp_str = substr($str, 0, 1);
            if (ord ($temp_str) > 127)
			{
                $i++;
                if ($i < $len)
				{
                    $new_str[] = substr($str, 0, 3);
                    $str = substr($str, 3);
                }
            }
			else
			{
                $new_str[] = substr($str, 0, 1);
                $str = substr($str, 1);
            }
        }

        $result = join ($new_str);
        $result .= (strlen($result) == strlen($string) ? '' : $etc);
        return $result;
    }

	public static function getGPC($key, $type = 'integer', $var = 'R')
	{
		switch($var)
		{
			case 'G': $var = &$_GET; break;
			case 'P': $var = &$_POST; break;
			case 'C': $var = &$_COOKIE; break;
			case 'R': $var = &$_REQUEST; break;
		}
		switch($type)
		{
			case 'integer':
				$return = isset($var[$key]) ? intval($var[$key]) : 0;
				break;
			case 'string':
				$return = isset($var[$key]) ? $var[$key] : NULL;
				break;
			case 'array':
				$return = isset($var[$key]) ? $var[$key] : array();
				break;
			default:
				$return = isset($var[$key]) ? intval($var[$key]) : 0;
		}
		return $return;
	}

	/**
	 * 过滤 html 标签
	 */
	public static function cleanHtmlTag($string, $strict = false)
	{
		$string = strip_tags($string);

		if(!$strict)
		{
			return $string;
		}
		$html_tag = "/<[\/|!]?(html|head|body|div|span|DOCTYPE|title|link|meta|style|p|h1|h2|h3|h4|h5|h6|strong|em|abbr|acronym|address|bdo|blockquote|cite|q|code|ins|del|dfn|kbd|pre|samp|var|br|a|base|img|area|map|object|param|ul|ol|li|dl|dt|dd|table|tr|td|th|tbody|thead|tfoot|col|colgroup|caption|form|input|textarea|select|option|optgroup|button|label|fieldset|legend|script|noscript|b|i|tt|sub|sup|big|small|hr)[^>]*>/is";

		return preg_replace($html_tag, '', $string);
	}

	/**
	 * 过滤 JavaScript 标签
	 */
	public static function cleanScript($string)
	{
		$string = preg_replace("/(javascript:)?on(click|load|key|mouse|error|abort|move|unload|change|dblclick|move|reset|resize|submit)/i","&111n\\2", $string);
		$string = preg_replace("/<script(.*?)>(.*?)<\/script>/si", '', $string);
		$string = preg_replace("/<iframe(.*?)>(.*?)<\/iframe>/si", '', $string);
		$string = preg_replace("/<object.+<\/object>/iesU", '', $string);
		return $string;
	}

	public static function safeReplace($string)
	{
		$string = str_replace('%20','',$string);
		$string = str_replace('%27','',$string);
		$string = str_replace('*','',$string);
		$string = str_replace('"','&quot;',$string);
		$string = str_replace("'",'',$string);
		$string = str_replace("\"",'',$string);
		$string = str_replace('//','',$string);
		$string = str_replace(';','',$string);
		$string = str_replace('<','&lt;',$string);
		$string = str_replace('>','&gt;',$string);
		$string = str_replace('(','',$string);
		$string = str_replace(')','',$string);
		$string = str_replace("{",'',$string);
		$string = str_replace('}','',$string);

		return $string;
	}

	/**
	 * 直接做合法性检验
	 * 调用案例：$id = XF_Util::removeUnSafe($_GET['id']);
	 */
	public static function removeUnSafe($string)
	{
		$string = preg_replace('/[\r\n\'"<>()\s]/', '', $string);

		return $string;
	}

	/**
	 * 对特殊字符做转义后输出
	 * $name = XF_Util::filterSafe($name);
	 */
	public static function filterSafe($string)
	{
		$string = preg_replace('/[\r]/', '', $string);
		$string = preg_replace('/[\n]/', '__br__', $string);
		$string = preg_replace('/\t/', ' ', $string);
		$string = preg_replace('/\'/', '??', $string);
		$string = preg_replace('/"/', '?°', $string);
		$string = htmlspecialchars($string);
		$string = preg_replace('/__br__/', '<br/>', $string);

		return $string;
	}
}
