<?php
/**
 * XF 数据库连接库
 *
 * @version 1.0
 * @author chuanwen.chen
 */
class Database
{
    private static $_instance;

	public static function getInstance()
	{
		if(!(self::$_instance instanceof self))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * master
	 */
	public function connectMasterDb($type = 'default')
	{
		$dbServer = $this->getDbConf($type, 'master');

		return $this->connectDb($dbServer);
	}

	/**
	 * slave
	 */
	public function connectSlaveDb($type = 'default')
	{
		$dbServer = $this->getDbConf($type, 'slave');

		return $this->connectDb($dbServer);
	}

	private function connectDb($dbServer)
	{
		$str = "mysql:host={$dbServer[0]};port={$dbServer[1]};dbname={$dbServer[4]}";
		$con[PDO::ATTR_TIMEOUT] = 1;
		// 此开关打开，支持长链接
		//if($GLOBALS['pconnect_db'] === true) $con[PDO::ATTR_PERSISTENT] = true;
		try
		{
			$db = new PDO($str, $dbServer[2], $dbServer[3], $con);
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
			return false;
		}

		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

		return $db;
	}

	private function getDbConf($type, $master)
	{
		$config = $GLOBALS['DBINFO'][$type];

		if($master)
		{
			$server = $config['master'];
		}
		else
		{
			$server = array_rand($config['slave']);
		}

		if(count($server)<=0 && !$server[0] == '')
		{
			throw new Exception('db server is empty.');
		}

		return $server;
	}
}
