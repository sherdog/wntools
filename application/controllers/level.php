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
		$levels = $this->level_model->getLevels();
		$data['levels'] = $levels;
		$this->load->view('level/index', $data);
	}

	function add()
	{
		//lets add a new level!
		$data['tracks'] = $this->level_model->getLevelTracks();
		$this->load->view('level/add', $data);
	}

	function add_level()
	{

		$track = $this->input->post('track');
		$level = $this->input->post('level');

		if($level == "" || $track == "")
		{
			$error = "Erorr in saving level ";
			if($track == "")
			{
				$error .= "Track not set";
			}
			if($level == "")
			{
				$error .= "Level no set";
			}
			$this->session->set_flashdata("error", "Error: " . $error);
		}

		if($this->level_model->createLevel($level, $track))
		{
			$this->session->set_flashdata('message', 'Created level successfully');
			redirect('level/edit/'.$level.'/'.$track);
		}
		else
		{
			$this->session->set_flashdata('error', 'error saving level');
			redirect('level/index');
		}
	}

	function save_info()
	{
		if($this->input->post())
		{
			if($this->input->post('_id') != '')
			{
				$levelID = $this->input->post('level_id');
				$level = $this->input->post('level');

				$_id = ($this->input->post('_id') != '') ? $this->input->post('_id') : null;

				$data = array(
					'last_modified' => date('Y-m-d G:i:a'),
					'complete' => array(
						'moves' => ($this->input->post('moves') != '') ? (int)$this->input->post('moves') : null,
						'time' => ($this->input->post('time') != '') ? (int)$this->input->post('time') : null
					)
				);

				$track = ($this->input->post('track')) ? $this->input->post("track") : 1;

				if($this->level_model->updateLevelInfo($_id, $levelID, $data))
				{
					$this->session->set_flashdata("message", "Updated level info");
					redirect('level/edit/'.$level.'/'.$track, 'refresh');
				}
				else
				{
					die('ERROR SAVING :(');
				}
				//if changing track do addition updates (like renaming)
				//probably shouldn't rename
			}
		}
	}

	function star_levels()
	{
		$level = $this->uri->segment(3);
		$track = $this->uri->segment(4);
		$levelID = $level . '_' . $track;

		$starLevels = $this->level_model->getStarLevels($levelID);

		$data['starLevels'] = $starLevels;

		$this->load->view('level/starlevels', $data);
	}

	function save_star_level()
	{
		$data = $this->input->post();
		if($this->level_model->saveStarLevels($data))
		{
			$this->session->set_flashdata('message', 'Saved star level successfully');
			redirect('level/star_levels/'.$this->input->post('level').'/'.$this->input->post('track'));
		}
	}
	

	function edit($levelNumber = null)
	{
		if($this->session->flashdata('message'))
		{
			$data['message'] = $this->session->flashdata('message');
		}

		$this->load->js('assets/js/level.js');

		$track = ($this->uri->segment(4) != '') ? $this->uri->segment(4) : 1;
		$level = $this->level_model->getLevels( ($levelNumber . "_" . $track) );

		if( !get_object_vars($level) )
		{
			$data['message'] = "Level " . $levelNumber . "_" . $track . " not found";
			$this->load->view('error', $data);
		}
		else
		{
			$data['level'] = (object)$level;
			$data['levelObjectiveTypes'] = $this->level_model->levelObjectiveTypes();
			$data['hidden'] = array('level_id'=>$level->level);
			$data['currentLevelObjectves'] = $this->level_model->getCurrentLevelObjectives($level->level);
			$data['levelID'] = $level;
			$data['level'] = $level;
			$data['trackOptions'] = $this->level_model->getLevelTracks();
			$data['js'] = array('assets/js/level.js');

			$this->load->view('level/edit', $data);
		}
	}

	function deleteobjective($id)
	{
		$this->load->model('level_model');
		//delete this beotch.
		$levelID = $this->level_model->deleteLevelObjective($id);
		redirect('/level/objectives/'.$levelID, 'refresh');
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

			$level = $this->uri->segment(3);
			$track = $this->uri->segment(4);
			$levelID = $level . '_' .  $track;

			$objectiveTypes = $this->level_model->levelObjectiveTypes();
			$levelData = $this->level_model->getLevels($levelID);

			$currentObjectives = ( property_exists($levelData, 'objectives')) ? $levelData->objectives : array();
			
			$data['objectiveTypes'] = $objectiveTypes;
			$data['currentObjectives'] = $currentObjectives;
			$data['levelID'] = $levelID;
			$data['levelData'] = $levelData;

			$data['level'] = $level;
			$data['track'] = $track;

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

			$type = set_value('objectiveType');
			$key = set_value('objectiveKey');
			$value = set_value('objectiveValue');
			$level = set_value('level');
			$track = set_value('track');

			$levelID = set_value('levelID');

			if( $this->level_model->addLevelObjective
				(
					$levelID, 
					$type, 
					$key, 
					$value
				)
			)
			{
			}
			else
			{
				$this->sesion->set_flashdata('message', 'Error saving objective');
			}

			redirect('level/objectives/'.$level.'/'.$track, 'refresh');


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

	function grid($id)
	{
		$this->load->model('level_model');
		//display grid setup.
		$this->load->js('assets/js/levelbuilder.js');

		//build the level_id field.
		$level = $this->uri->segment(3);
		$trackID = ($this->uri->segment(4)!='') ? $this->uri->segment(4) : 1;
		$levelID = $level . '_' . $trackID;

		$levelData = $this->level_model->getLevelGrid($levelID);
		$grid = (property_exists($levelData, "grid")) ? $levelData->grid : array();
		$data['grid'] = $grid;

		//set row col vals
		$data['rows'] = (count($grid)) ? count($grid) : '';
		$data['cols'] = (count($grid) && count($grid[0])) ? count($grid[0]) : '';
		
		$this->load->view('tools/levelbuilder', $data);
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