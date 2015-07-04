<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {

	function serializelevel()
	{
		if($this->input->post())
		{
			error_log('get was set');
			echo serialize($this->input->post('data'));

		}
	}

	function printjson()
	{
		echo print_r($this->input->post('data'),true);
	}
}	