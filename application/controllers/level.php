<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Level extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$this->_init();
	}

	function _init()
	{
		$this->load->model('level_model');
		$this->output->set_template('default');
		$this->output->set_common_meta('Word Ninja Quest Admin :: Levels', '', '');

	}

	function index()
	{
		//get all levels. yah.
		$data['levels'] = $this->level_model->getLevels();
		$this->load->view('level/index', $data);
	}

	function edit($levelID)
	{
		if($this->input->post())
		{
			//SAVE THE DATAZ
		}
		else
		{

			if($this->session->flashdata('message'))
			{
				$data['message'] = $this->session->flashdata('message');
			}

			$this->load->js('assets/js/level.js');
			$level = $this->level_model->getLevels($levelID);

			$data['level'] = $level;

			$data['levelId'] = array(
				'name' => 'level_id',
				'id'	=> 'level_id',
				'type'	=> 'text',
				'class'	=> 'form-control',
				'disabled' => '',
				'value' => $data['level']->level
			);

			$data['objectTypeOptions'] = array(
				'move_bonus' => 'Bonus/Moves',
				'time_bonus' => 'Bonus/Time',
				'move_score' => 'Score/Moves',
				'time_score' => 'Score/Time',
				'move_words' => 'Words/Moves',
				'time_words' => 'Words/Time',
				'move_brick' => 'Bricks/Moves',
				'time_brick' => 'Bricks/Time'
			);

			$data['moves'] = ($level->moves) ? $level->moves : 0;
			$data['time'] = ($level->time) ? $level->time : 0;

			//for the select dropdown. yeah boy.
			$data['levelObjectiveTypes'] = $this->level_model->levelObjectiveTypes();
			$data['hidden'] = array('level_id'=>$level->level);
			$data['currentLevelObjectves'] = $this->level_model->getCurrentLevelObjectives($level->level);

			$data['js'] = array('assets/js/level.js');

			$this->load->view('level/edit', $data);
		}
		
	}

	function objectives($id = null)
	{

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		$this->form_validation->set_rules('objectiveValue', 'Value', 'required');

		if($this->form_validation->run() === FALSE)
		{
			//Load view.
			$this->load->model('level_model');
			$data['objectiveTypes'] = $objectiveTypes = $this->level_model->levelObjectiveTypes();
			$data['currentObjectives'] = $objectives = $this->level_model->getCurrentLevelObjectives($id);
			$data['level'] = $id;

			$this->load->view('level/objectives', $data);
		}
		else
		{
			//setup the form data for insertion.
			$formData = array(
				'level_objective_type_id' => set_value('objectiveType'),
				'key'	=> set_value('objectiveKey'),
				'value' => set_value('objectiveValue'),
				'level_id' => set_value('levelID')
			);

			$levelID = set_value('levelID');

			if( $this->level_model->addLevelObjective($formData) )
			{
				//Yay! we can redurec back for another addition.
				redirect('level/objectives/'.$levelID, 'refresh');
			}
			else
			{
				echo "Error saving objective";
			}


		}
		
	}

	function addLevelObjective($id)
	{
		$this->output->set_template('json');
		$this->load->helper('objective_type_helper');
		//do some type checking and return the right html
		$content = $this->objective_type_helper->getFormContent($id);
		$return = array(
			'title'=>'Add Level Objective ' . $id, 
			'content' => ' This will be ' . $id .'s content '
		);
		echo json_encode($return);

	}

	function addobjective()
	{

		$dataArray = array(
			'level_id' 	=> $this->input->post('level_id'),
			'type' 		=> $this->input->post('level_objective_type_id'),
			'track' 	=> 1
		);

		$levelID = $this->input->post('level_id');

		if(!$this->level_model->addObjective($dataArray))
		{
			$this->session->set_flashdata('message', 'Error saving objective');
		}


		redirect('level/edit/'.$levelID, 'refresh');
	}

	function saveobjective()
	{
		$this->set->set_template('json');
		
		if(!$this->input->post())
		{
			echo json_encode(array('status'=>'error'));
		}
	}

}