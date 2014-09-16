<?php
/**
 * The base controller
 * 
 * @category  Controller
 * @copyright copyright (c) 2005-2012 Wangcan's studio
 * @license   http://www.wangcanliang.com/license/
 */
class base
{
	/**
	 * Constuct method
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->password = md5('studio');
		$passwordCookie = isset($_COOKIE['studio_password']) ? $_COOKIE['studio_password'] : '';
		
		if ((getgpc('c') =='index' && (getgpc('m') == 'login' || getgpc('m') == 'logout'))) {
			return ;
		}
		if ($passwordCookie != $this->password) {
			header('Location: ' . ROOT_API . '/index.php?c=index&m=login');
		}
	}
	
	/**
	 * Show the page
	 * 
	 * @return void
	 */
	protected function _view($viewFile)
	{
		$viewPath = ROOT_PATH . 'view/';
		
		$viewFileFull = $viewPath . $viewFile . '.php';
		if (file_exists($viewFileFull)) {
			ob_start();
			include $viewFileFull;
			ob_end_flush();
			exit();
		} else {
			exit('view file "' . $viewFile . '" is not exist!');
		}
	}
}