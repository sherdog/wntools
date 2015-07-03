<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');

		$this->_init();
	}

	private function _init()
	{
		$this->output->set_template('default');
		$this->output->set_common_meta('Word Ninja Quest Admin', '', '');
	}

	public function index()
	{
		$this->load->view('ci_simplicity/welcome');
	}

	
}
