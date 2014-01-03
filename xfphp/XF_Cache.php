<?php
class XF_Cache
{
	private $cacheDir = APP_CACHE_DIR;

	private static function getFileName($key)
	{
		return $cacheDir . $key . '.php';
	}

	public static function set($key, $value)
	{
		$value = var_export($value, true);
		$content = "<?php\n";
		$content .= '$' . $key . ' = ' . $value . ';\n';
		$content .= 'return &$' . $key . ';\n';

		$fileName = self::getFileName($key);
		file_put_contents($fileName, $content);
	}

	public static function get($key)
	{
		$fileName = self::getFileName($key);

		if(!file_exists($fileName) || !is_readable($fileName))
		{
			throw new XF_Exception($fileName . ' not exist.');
		}

		include($fileName);
	}
}
