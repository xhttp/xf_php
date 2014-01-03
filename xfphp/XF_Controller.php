<?php
abstract class XF_Controller_Abstract
{
	protected $request = null;

	protected $response = null;

	protected $database = null;

	protected $template = null;

	public function init()
	{
		$this->request = XF_Request::getInstance();

		$this->response = XF_Request::getInstance();

		$this->database = XF_Database::getInstance();

		$this->template = $this->smarty();
	}

	private function smarty()
	{
		include(LIB_DIR . 'smarty/Smarty.class.php');

		$smarty = new Smarty();

		$smarty->left_delimiter = '<!--{';
		$smarty->right_delimiter = '}-->';

		$smarty->compile_check = false;
		$smarty->caching = false;
		//$smarty->force_compile = true;
		//$smarty->debugging = true;
		//$smarty->caching = true;
		//$smarty->cache_lifetime = 120;


		$smarty->template_dir = APP_VIEW_DIR;
		$smarty->compile_dir = APP_VIEWC_DIR;
		//$smarty->config_dir = '/web/www.mydomain.com/smarty/guestbook/configs/';
		//$smarty->cache_dir = '/web/www.mydomain.com/smarty/guestbook/cache/';

		return $smarty;
	}
}
