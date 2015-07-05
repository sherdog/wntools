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

		$data['levelObjectiveValues'] = $this->level_model->levelObjectives($level->level);

		$data['objectTypeKeys'] = $this->level_model->getObjectiveKeys();
		$data['selectedObjectiveType'] = $level->objective_type;


		$this->load->view('level/edit', $data);
	}

}