<?php
$GLOBALS = array(
				'Shutdown' => 0,
				'Debug' => 1,
				'TimeZone' => 'Asia/Shanghai', 
				'CharSet' => 'UTF-8',
				'MAGIC_QUOTES_GPC' => get_magic_quotes_gpc(),
				'DBINFO' => array(
								'defalut' => array(
												'master' => array('127.0.0.1', 3306, 'root', '', 'test'),
												'slave' => array(
																array('127.0.0.1', 3306, 'root', '', 'test'),
																array('127.0.0.1', 3306, 'root', '', 'test')
																)
												)
								)
				);
