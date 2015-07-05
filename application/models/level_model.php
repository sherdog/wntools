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
		$this->db->select('title,id');
		$this->db->from('level_objective_types');

		$query = $this->db->get();

		return $query->result();
	}

	function getCurrentLevelObjectives($levelID = null)
	{
		//join the objecitves and values table.
		if($levelID === null)
		{
			return nulll;
		}


		$this->db->select('level_objectives.type, level_objective_values.key, level_objective_values.value, level_objective_types.title, level_objective_types.value AS levelObjectSlug');
		$this->db->from('level_objectives');
		$this->db->join('level_objective_values', 'level_objectives.id', 'level_objective_values.level_objective_id', 'left');
		$this->db->join('level_objective_types', 'level_objective_values.level_objective_type_id' , 'level_objectives_types.id', 'left');

		$this->db->where('level_objectives.level_id', $levelID);

		$query = $this->db->get();

		$results = $query->result();

		error_log('Results for current level objectives: ' . print_r($results,true));
		error_log('SQL for level objectives for level: ' . $levelID . ' ' . $this->db->last_query());

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