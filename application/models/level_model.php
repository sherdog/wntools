<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class level_model extends CI_Model
{

	static $objectiveValueKeys = array('moves', 'time', 'score_tier', 'word');

	function getLevels($level = null)
	{
		$this->db->select('track_id,background,level,thumbnail,objective_type,board_type');
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

		$this->db->select('lov.key, lov.value, lov.level_objective_id');
		$this->db->from('level_objective_values AS lov');
		$this->db->join('level_objectives_new AS lo', 'lov.level_objective_id', 'lo.type', 'inner');
		$this->db->where('lo.level_id', $levelID);

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