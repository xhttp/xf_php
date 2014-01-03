<?php
class IndexController extends XF_Controller_Abstract
{
	public function __construct()
	{
		parent::init();
	}

	public function indexAction()
	{
		echo $this->request->getNum('id');
	}

	public function testAction()
	{
		echo 'test';
	}

	public function testDB()
	{
		$db = $this->database->connectDb();

		$sql  = 'INSERT INTO table(uid, content) VALUES (?,?)';
		$st = $db->prepare($sql);
		$ret = $st->execute(array($array['uid'], $array['content']));
		if($ret)
		{
			echo $db->lastInsertId();
		}

		//==========================
		$sql  = "DELETE FROM table WHERE uid = ?";
		$st = $db->prepare($sql);
		$ret = $st->execute(array($uid));
        if(!$ret)
		{
			return false;
		}

		//==========================
		$sql  = 'DELETE FROM table WHERE uid = ?';
		$st = $db->prepare($sql);
		$ret = $st->execute(array($uid));
		$row = $st->rowCount();
		if(!$ret)
		{
            return false;
		}

		//==========================
		$sql = "SELECT * FROM table WHERE uid = $uid";
		$st = $db->prepare($sql);
		$ret = $st->execute();
        if(!$ret)
		{
			return false;
		}
		$returnArray = $st->fetchAll(PDO::FETCH_ASSOC);

		//==========================
		$sql = "SELECT COUNT(*) FROM table WHERE uid = $uid";
		$st = $db->prepare($sql);
		$ret = $st->execute();
        if(!$ret)
		{
			return false;
		}
		$totalnum = $st->fetch(PDO::FETCH_COLUMN);

		$st = null;
		$db = null;
	}

	public function __destruct()
	{
		$this->database = null;
	}
}
