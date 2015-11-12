<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->_init();
	}

	function _init()
	{
		$this->load->model('level_model');
	}	

	function serializelevel()
	{
		if($this->input->post())
		{
			error_log('get was set');

			echo base64_encode(serialize($this->input->post('data')));

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

	function save_grid()
	{
		$data = $this->input->post('data');
		$trackID = $this->input->post('track');
		$levelID = $this->input->post('level');

		$level = $levelID . "_" . $trackID;

		$save = array(
			'last_modified' => date('Y-m-d G:i:s'),
			'grid' => json_decode($data)
		);
		

		if($this->level_model->save_grid_info($level, $save))
		{
			echo json_encode(array('status'=>'ok'));
		}
		else
		{
			echo json_encode(array('status'=>'error'));
		}

	}
}	