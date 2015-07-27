<?php defined('BASEPATH') OR exit('No direct script access allowed');


class tile extends objective
{
	//define tiles properties.
	//tiles can be collected by letter or by just #of ties
	//"-" denotes any tile

	var $struct = array('name' => 'string', 'val' => 'int');

	private $_ci = '';

	private $_inputArray = array();

	function __construct()
	{
		$this->_ci =& get_instance();
	}

	function getInputs()
	{
		//returns array of input fields
		foreach($struct as $key=>$val)
		{
			$_inputArray[] = array('type'=>getType($val), 'name'=>$key, 'id'=>$key);
		}
	}

	function getType($val)
	{
		//build HTML form and return it
		switch($val)
		{
			case 'string' :
			case 'int' :
				return 'text';
			break;
			case
		}

	}

	//return html form for adding.
}