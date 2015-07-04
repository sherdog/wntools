<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tools extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		
		if (!$this->ion_auth->logged_in())
		{
			redirect('login');
		}

		$this->_init();

	}

	function _init()
	{
		$this->output->set_template('default');
		$this->output->set_common_meta('Word Ninja Quest Admin :: Tools', '', '');
	}

	function index()
	{

		$this->levelbuilder();
	}

	function levelbuilder()
	{

		//we are going to fucking make leves with a gui.
		$this->load->js('assets/js/levelbuilder.js');
		$this->load->view('tools/levelbuilder');
	}
}