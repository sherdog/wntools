<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class level_model extends CI_Model
{

	static $objectiveValueKeys = array('moves', 'time', 'score_tier', 'word');

	function getLevels($level = null)
	{
		$this->db->select('track_id,background,level,thumbnail,moves,time,board_type');
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

	function deleteLevelObjective($id)
	{
		//first we get the type and then
		//check to see if there are any records in the level_objectives_new
		//table - if there is we need to remove it from that table.

		$this->db->select('level_objective_type_id, level_id');
		$this->db->from('level_objective_values');
		$this->db->where('id', $id);

		$query = $this->db->get();

		$row = $query->row();

		//we have the type now let's see how many records there are.

		$this->db->select('id');
		$this->db->from('level_objective_values');
		$this->db->where('level_objective_type_id', $row->level_objective_type_id);

		$query = $this->db->get();

		$count = $query->num_rows();

		if($count === 1)
		{
			//we are going to remove the type from level_objectives_new
			 $this->db->delete('level_objectives_new', array('type' => $id, 'level_id' => $row->level_id)); 
		}

		//now let's delete the fucking row.
		$this->db->delete('level_objective_values', array('id', $id));

		return true;
	}

	function addLevelObjective($data)
	{
		//add it to the level_objectives table
		//check to see if a type exists.

		$this->db->select('id');
		$this->db->from('level_objectives_new');
		$this->db->where('type', $data['level_objective_type_id']);

		$query = $this->db->get();

		if(!$query->num_rows())
		{
			$levelObjectives = array(
			'level_id' => $data['level_id'],
			'type' => $data['level_objective_type_id']
			);

			$this->db->insert('level_objectives_new',$levelObjectives);

			$levelObjectiveID = $this->db->insert_id();
		}
		else
		{
			$row = $query->row();
			$levelObjectiveID = $row->id;
		}
		
		$data['level_objective_id'] = $levelObjectiveID;

		return $this->db->insert('level_objective_values', $data);
	}

	function updateLevelObjective($id,$data)
	{
		$this->db->where('id', $id);
		return $this->db->update('level_objective_values', $data);
	}

	function levelObjectiveTypes()
	{
		$this->db->select('title,id,value');
		$this->db->from('level_objective_types');

		$query = $this->db->get();

		return $query->result();
	}

	function addObjective($data)
	{
		if(!is_array($data))
			return false;

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

		$this->db->select('lot.title, lov.key, lov.value');
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