<?php
/**
 * The index controller, show the main frame of the application, logout etc.
 * 
 * @see       ./base.php;
 * @category  Controller
 * @copyright copyright (c) 2005-2012 Wangcan's studio
 */
class index extends base
{
	/**
	 * Construct function
	 * 
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Manager login
	 *
	 * @return void
	 */
	public function onlogin()
	{
		$doSubmit = isset($_POST['dosubmit']) ? $_POST['dosubmit'] : '';
		if (empty($doSubmit)) {
			$this->loginInfo = 'LOGIN';
			$this->_view('login');
		} else {
			$password = isset($_POST['password']) ? $password : '';
			
		}
	}
	
	/**
	 * 
	 */
}