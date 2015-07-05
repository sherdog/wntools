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
		$this->db->select('type, value, track');
		$this->db->from('level_objectives');
		$this->db->where('level_id', $levelID);

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