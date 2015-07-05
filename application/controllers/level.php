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

			$data['selectedLevelObjectiveType'] = $level->objective_type;

			//for the select dropdown. yeah boy.
			$data['levelObjectiveTypes'] = $this->level_model->levelObjectiveTypes();

			$data['currentLevelObjectves'] = $this->level_model->getCurrentLevelObjectives($level->level);
			$data['js'] = array('assets/js/level.js');
			$this->load->view('level/edit', $data);
		}
		
	}

}