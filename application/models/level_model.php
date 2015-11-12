<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class level_model extends CI_Model
{

	static $disabledColVal = -1;
	static $defaultTrack = 1;
	static $objectiveValueKeys = array('moves', 'time', 'score_tier', 'word');

	static $properties = array(
		'level_id' => "",
		"level" => -1,
		'track' => -1,
		'complete' => array('moves' => -1, 'time' => -1),
		'objectives' => array(),
		'star_levels' => array(),
		'grid' => array(),
		'bonus' => array(),
		'date_created' => '',
		'last_modified' => ''
	);

	function __construct()
	{
		parent::__construct();
	}

	function levelUpdatedCallback($arr)
	{
		//this is called anytime a level is updated.
		$level = $arr['level_id'];

		$data['updated_at'] = time();

		$this->db->where('level', $level);
		$this->db->where('track_id', $track);

		$this->db->update('levels', $data);
	}

	function getLevelTracks()
	{
		$this->db->select('track_name, default, id');
		$this->db->from('tracks');

		$query = $this->db->get();

		return $query->result();
	}

	function updateLevelInfo($_id, $levelID, $arr)
	{
		//get the data?s
		if(is_array($arr))
		{	
			if($levelID)
			{
				return $this->mongo_db->where(array('level_id'=>$levelID))->set($arr)->update('levels');
			}
			return false;
		}
		return false;
	}

	function getLevels($levelID = null)
	{
		if($levelID)
		{
			try
			{
				$this->mongo_db->where(array('level_id' => $levelID ));
				$data = $this->mongo_db->row('levels');
				return (object)$data;
			}
			catch(Exception $e)
			{
				$data['message'] = "Level '".$_levelID."' not found";
				$this->load->view('error', $data);
			}
		}
		else
		{
			$data = $this->mongo_db->get('levels');
			return (object)$data;
		}

		/*

		$this->db->select('track_id,background, updated_at, created_at, last_uploaded,level,thumbnail,moves,time,board_type');
		$this->db->from('levels');

		if($level !== null)
		{
			$this->db->where('level', $level);
		}

		$query = $this->db->get();

		if($level !== null)
		{
			return $query->row();
		}
		else
		{
			return $query->result();
		}
		*/
	}

	function getObjectiveKeys()
	{
		return self::$objectiveValueKeys;
	}

	function levelScoreTiers($levelID)
	{
		$this->db->select('score_level, score');
		$this->db->from('score_tiers');
		$this->db->where('level_id', $levelID);

		$query = $this->db->get();

		return $query->result();
	}

	function save_objective($dataArray)
	{
		//check ot make sure it doesn't already exist.
		$this->db->where('level_id', $dataArray['level']);
		$this->db->where('type', $dataArray['type']);
		$this->db->from('level_objectives_new');

		if($this->db->count_all_results())
		{
			$this->db->insert('level_objectives_new', $dataArray);
		}
		else
		{
			$this->db->where('type', $dataArray['type']);
			$this->db->where('level_id', $dataArray['level']);
			$this->db->set('value', $dataArray['value']);
			$this->db->update('level_objectives_new');
		}

		$updateArray['level_id'] = $dataArray['level'];
		$levelUpdatedCallback($updateArray);

		return true;
	}

	function levelObjectives($levelID)
	{
		$this->db->select('type');
		$this->db->from('level_objectives');
		$this->db->where('level_id', $levelID);

		$query = $this->db->get();



		return $query->result();
	}

	function save_grid_info($levelID, $arr)
	{
		if($levelID != '')
		{
			error_log('levelID was set');
			error_log('Saving to mongo - level_id='.$levelID .' and arr: ' . print_r($arr,true));
			return $this->mongo_db->where(array('level_id'=>$levelID))->set($arr)->update('levels');
		}

		return false;	
	}

	function createLevel($level, $track)
	{
		if($level == "" || $track == "")
		{
			return false;
		}

		$data = self::$properties;

		$data['level'] = $level;
		$data['track'] = $track;
		$data['level_id'] = $level . '_' . $track;

		return $this->mongo_db->insert('levels', $data);
	}

	function getLevelGrid($levelID)
	{
		//get the levels grid.
		try
		{
			$this->mongo_db->select('grid');
			$this->mongo_db->where(array('level_id' => $levelID ));
			$data = $this->mongo_db->row('levels');
			
		}
		catch(Exception $e)
		{
			$data['message'] = "Level '".$_levelID."' not found";
			$this->load->view('error', $data);
		}

		return (object)$data;
	}

	function deleteLevelObjective($id)
	{
		//first we get the type and then
		//check to see if there are any records in the level_objectives_new
		//table - if there is we need to remove it from that table.
		error_log('delete level objective: ' . $id);
		$this->db->select('level_objective_type_id, level_id');
		$this->db->from('level_objective_values');
		$this->db->where('id', $id);

		$query = $this->db->get();

		$row = $query->row();

		$levelID = $row->level_id;
		$objectiveID = $row->level_objective_type_id;
		//we have the type now let's see how many records there are.

		$this->db->select('id');
		$this->db->from('level_objective_values');
		$this->db->where('level_objective_type_id', $objectiveID);

		$query = $this->db->get();

		$count = $query->num_rows();

		if($count === 1)
		{
			$this->db->where('type', $objectiveID);
			$this->db->where('level_id', $levelID);
			//we are going to remove the type from level_objectives_new
			 $this->db->delete('level_objectives_new'); 
		}

		//now let's delete the fucking row.
		$this->db->where('id', $id);
		$this->db->delete('level_objective_values');

		$updateArray['level_id'] = $levelID;
		$levelUpdatedCallback($updateArray);

		return $levelID;
	}

	function getLevelObjectivesForLevel($levelID)
	{
		$this->mongo_db->select('objectives');
		$this->mongo_db->where(array('level_id' => $levelID ));
		$data = $this->mongo_db->row('levels');

		return ($data['objectives']['types']) ? $data['objectives']['types'] : array();
	}

	function getStarLevels($levelID)
	{
		try
		{
			$this->mongo_db->select('star_levels');
			$this->mongo_db->where(array('level_id' => $levelID ));
			$data = $this->mongo_db->row('levels');
		}
		catch(Exception $e)
		{
			$data['message'] = "Error " . $e;
			$this->load->view('error', $data);
		}

		$starLevels = (array_key_exists('star_levels', $data)) ? $data['star_levels'] : array();
		return $starLevels;
	}

	function saveStarLevels($data)
	{
		$level = $data['level'];
		$track = $data['track'];
		$levelID = $level . '_' . $track;

		$arr['star_levels'] = $data['starLevel'];
		return $this->mongo_db->where(array('level_id'=>$levelID))->set($arr)->update('levels');
	}

	function addLevelObjective($levelID, $type, $key, $val)
	{
		//add it to the level_objectives table
		//check to see if a type exists.

		//get level objectives for level.
		$obj = $this->getLevelObjectivesForLevel($levelID);
		//first check to see if the type exists.
		if(array_key_exists($type, $obj))
		{
			error_log('array key exists: ' . $type . ' now to find key: ' . $key . ' and set it to val: ' . $val);

			if(!array_key_exists($key, $obj[$type]))
			{
				$obj[$type][$key] = $val;
			}
			else
				error_log('array key didnt exist in ' . print_r($obj[$type],true));

			if(array_key_exists($obj[$type], $key) && $obj[$type][$key] != $val)
			{
				$obj[$type][$key] = $val;
			}
		}
		else
		{
			error_log('type no found in object: ' . $type);
			$obj[$type] = array($key => $val);
		}

		error_log('we done with the object what is it? ' . print_r($obj,true));
		
		$arr['objectives']['types'] = $obj;

		return $this->mongo_db->where(array('level_id'=>$levelID))->set($arr)->update('levels');
	}

	function updateLevel($data)
	{
		$timestamp = time();
		$saveData = array();
		//update the level.
		if(!$data->level_id)
		{
			$saveData['created_at'] = time();
		}

		$saveData['updated_at'] = time();
		
		$saveData['time'] = ($data->time) ? $data->time : $disabledColVal;
		$saveData['moves'] = ($data->moves) ? $data->moves : $disabledColVal;

		$trackID = ($data->track) ? $data->track : $defaultTrack;
		$saveData['track_id'] = $trackId;

		if($this->level_id)
		{
			$this->db->where('level', $data->level_id);
			$this->db->where('track_id', $trackId);
			$this->db->update('levels', $saveData);
		}
		else
		{
			$this->db->insert('levels', $saveData);
		}

		$updateArray['level_id'] = $data->level_id;
		$levelUpdatedCallback($updateArray);

		return true;
	}

	function updateLevelObjective($id,$data)
	{
		$this->db->where('id', $id);
		
		$updateArray['level_id'] = $data->level_id;
		$levelUpdatedCallback($updateArray);

		return $this->db->update('level_objective_values', $data);

	}

	function levelObjectiveTypes()
	{
		$this->mongo_db->where(array('_name' => 'objectiveTypes' ));
		$data = $this->mongo_db->row('objective_types');
		
		return (object)$data;
	}

	function addObjective($data)
	{
		if(!is_array($data))
			return false;

		$updateArray['level_id'] = $data->level_id;
		$levelUpdatedCallback($updateArray);
		
		$this->db->insert('level_objectives_new', $data);

		return true;
	}

	function getCurrentLevelObjectives($levelID = null)
	{
		//join the objecitves and values table.
		if($levelID === null)
		{
			return nulll;
		}

		$this->db->select('lot.title, lov.key, lov.value, lov.id');
		$this->db->from('level_objective_values AS lov');
		$this->db->join('level_objective_types AS lot', 'lot.id = lov.level_objective_type_id', 'right');
		$this->db->where('lov.level_id', $levelID);

		$query = $this->db->get();

		$results = $query->result();

		return $results;
	}

	function levelObjectiveValues()
	{
		$this->db->select('*');
		$this->db->from('level_objective_values');
		$this->db->where('level_obective_id', $objectiveID);

		$query = $this->db->get();

		return $query->result();
	}

	function levelWordObjectives($levelID)
	{
		$this->db->select('word_length, count, track');
		$this->db->from('level_word_objectives');
		$this->db->where('level_id', $levelID);

		$query = $this->db->get();

		return $query->result();
	}

	function levelGrid($levelID)
	{
		$this->db->select('grid_data');
		$this->db->from('level_grids');
		$this->db->where('level_id', $levelID);

		$query = $this->db->get();

		return $query->row();
	}

	function levelBonusWords($levelID)
	{
		//now sure if I am going to use this or not.
		//bahaha. shitballs.
	}
}