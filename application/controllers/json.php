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

	function saveobjective()
	{
		if(!$this->input->post())
		{
			echo json_encode(array('status'=>'error'));
		}
		else
		{
			$type = $this->input->post('type');
			$value = $this->input->post('value');
			$level = $this->input->post('level');

			$update['type'] = $type;
			$update['value'] = $value;
			$update['level_id'] = $level;
			
			if($this->level_model->save_objective($update))
			{
				echo json_encode(array('status'=>'ok'));
			}
		}
	}
}	