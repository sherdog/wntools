<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$this->_init();
	}

	private function _init()
	{
		$this->output->set_template('default');

	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	
}
