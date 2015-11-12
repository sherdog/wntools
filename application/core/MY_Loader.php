<?php
/**
 * PHP Codeigniter Simplicity
 *
 * Copyright (C) 2013  John Skoumbourdis.
 *
 * GROCERY CRUD LICENSE
 *
 * Codeigniter Simplicity is released with dual licensing, using the GPL v3 and the MIT license.
 * You don't have to do anything special to choose one license or the other and you don't have to notify anyone which license you are using.
 * Please see the corresponding license file for details of these licenses.
 * You are free to use, modify and distribute this software, but all copyright information must remain.
 *
 * @package    	Codeigniter Simplicity
 * @copyright  	Copyright (c) 2013, John Skoumbourdis
 * @license    	https://github.com/scoumbourdis/grocery-crud/blob/master/license-grocery-crud.txt
 * @version    	0.6
 * @author     	John Skoumbourdis <scoumbourdisj@gmail.com>
 */
class MY_Loader extends CI_Loader {

	private $_javascript = array();
	private $_css = array();
	private $_inline_scripting = array("infile"=>"", "stripped"=>"", "unstripped"=>"");
	private $_sections = array();
	private $_cached_css = array();
	private $_cached_js = array();

	protected $_ci_events_paths = array();

	function __construct(){

		if(!defined('SPARKPATH'))
		{
			define('SPARKPATH', 'sparks/');
		}

		$this->_ci_events_paths = array(APPPATH);

		parent::__construct();
	}

	function css(){
		$css_files = func_get_args();

		foreach($css_files as $css_file){
			$css_file = substr($css_file,0,1) == '/' ? substr($css_file,1) : $css_file;

			$is_external = false;
			if(is_bool($css_file))
				continue;

			$is_external = preg_match("/^https?:\/\//", trim($css_file)) > 0 ? true : false;

			if(!$is_external)
				if(!file_exists($css_file))
					show_error("Cannot locate stylesheet file: {$css_file}.");

			$css_file = $is_external == FALSE ? base_url() . $css_file : $css_file;

			if(!in_array($css_file, $this->_css))
				$this->_css[] = $css_file;
		}
		return;
	}

	function js(){
		$script_files = func_get_args();

		foreach($script_files as $script_file){
			$script_file = substr($script_file,0,1) == '/' ? substr($script_file,1) : $script_file;

			$is_external = false;
			if(is_bool($script_file))
				continue;

			$is_external = preg_match("/^https?:\/\//", trim($script_file)) > 0 ? true : false;

			if(!$is_external)
				if(!file_exists($script_file))
					show_error("Cannot locate javascript file: {$script_file}.");

			$script_file = $is_external == FALSE ?  base_url() . $script_file : $script_file;

			if(!in_array($script_file, $this->_javascript))
				$this->_javascript[] = $script_file ;

		}

		return;
	}

	function start_inline_scripting(){
		ob_start();
	}

	function end_inline_scripting($strip_tags=true, $append_to_file=true){
		$source = ob_get_clean();

		 if($strip_tags){
			 $source = preg_replace("/<script.[^>]*>/", '', $source);
			 $source = preg_replace("/<\/script>/", '', $source);
		 }

		 if($append_to_file){

		 	$this->_inline_scripting['infile'] .= $source;

		 }else{

		 	if($strip_tags){
		 		$this->_inline_scripting['stripped'] .= $source;
		 	}else{
		 		$this->_inline_scripting['unstripped'] .= $source;
		 	}
		 }
	}

	function get_css_files(){
		return $this->_css;
	}

	function get_cached_css_files(){
		return $this->_cached_css;
	}

	function get_js_files(){
		return $this->_javascript;
	}

	function get_cached_js_files(){
		return $this->_cached_js;
	}

	function get_inline_scripting(){
		return $this->_inline_scripting;
	}

	/**
	 * Loads the requested view in the given area
	 * <em>Useful if you want to fill a side area with data</em>
	 * <em><b>Note: </b> Areas are defined by the template, those might differs in each template.</em>
	 *
	 * @param string $area
	 * @param string $view
	 * @param array $data
	 * @return string
	 */
	function section($area, $view, $data=array()){
		if(!array_key_exists($area, $this->_sections))
			$this->_sections[$area] = array();

		$content = $this->view($view, $data, true);

		$checksum = md5( $view . serialize($data) );

		$this->_sections[$area][$checksum] = $content;

		return $checksum;
	}

	function get_section($section_name)
	{
		$section_string = '';
		if(isset($this->_sections[$section_name]))
			foreach($this->_sections[$section_name] as $section)
				$section_string .= $section;

		return $section_string;
	}
	/**
	 * Gets the declared sections
	 *
	 * @return object
	 */
	function get_sections(){
		return (object)$this->_sections;
	}

   /*
    * Can load a view file from an absolute path and
    * relative to the CodeIgniter index.php file
    * Handy if you have views outside the usual CI views dir
    */
    function viewfile($viewfile, $vars = array(), $return = FALSE)
    {
		return $this->_ci_load(
            array('_ci_path' => $viewfile,
                '_ci_vars' => $this->_ci_object_to_array($vars),
                '_ci_return' => $return)
        );
    }


    	/**
    	 * Specific Autoloader (99% ripped from the parent)
    	 *
    	 * The config/autoload.php file contains an array that permits sub-systems,
    	 * libraries, and helpers to be loaded automatically.
    	 *
    	 * @access	protected
    	  * @param	array
    	  * @return	void
    	  */
   function _ci_autoloader($basepath = NULL)
   {
    	  if($basepath !== NULL)
    	  {
    	  $autoload_path = $basepath.'config/autoload.php';
    }
    else
    {
    $autoload_path = APPPATH.'config/autoload.php';
    }

    	 if(! file_exists($autoload_path))
    	 {
    	 	return FALSE;
    	 }

    	 	include_once($autoload_path);

    	 	if ( ! isset($autoload))
    		{
    			return FALSE;
    	 	}

    	 	// Autoload packages
    	 		if (isset($autoload['packages']))
    		{
    			foreach ($autoload['packages'] as $package_path)
    	 		{
    				$this->add_package_path($package_path);
    	 		}
    	 		}

    	 		// Autoload sparks
    	 		if (isset($autoload['sparks']))
    	 		{
    	 			foreach ($autoload['sparks'] as $spark)
    	 			{
    	 			$this->spark($spark);
    	 }
    		}

    			if (isset($autoload['config']))
    			{
    			// Load any custom config file
    			if (count($autoload['config']) > 0)
    			{
    			$CI =& get_instance();
                    foreach ($autoload['config'] as $key => $val)
    			{
    			$CI->config->load($val);
    			}
    			}
    			}

    			// Autoload helpers and languages
    			foreach (array('helper', 'language') as $type)
    				{
    			if (isset($autoload[$type]) AND count($autoload[$type]) > 0)
    				{
    					$this->$type($autoload[$type]);
    			}
    			}

    			// A little tweak to remain backward compatible
    			// The $autoload['core'] item was deprecated
    			if ( ! isset($autoload['libraries']) AND isset($autoload['core']))
    			{
    			$autoload['libraries'] = $autoload['core'];
    }

    			// Load libraries
    			if (isset($autoload['libraries']) AND count($autoload['libraries']) > 0)
    			{
    			// Load the database driver.
    			if (in_array('database', $autoload['libraries']))
    			{
    			$this->database();
    			$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
    }

    			// Load all other libraries
    			foreach ($autoload['libraries'] as $item)
    			{
    			$this->library($item);
    }
    }

    			// Autoload models
    			if (isset($autoload['model']))
    			{
    			$this->model($autoload['model']);
    			}
    }

    /** Load a events module * */
    public function event($event = '', $params = NULL, $object_name = NULL)
    {
        if (is_array($event))
        {
            foreach ($event as $class)
            {
                $this->library($class, $params);
            }

            return;
        }

        if ($event == '' OR isset($this->_base_classes[$event]))
        {
            return FALSE;
        }

        if ( ! is_null($params) && ! is_array($params))
        {
            $params = NULL;
        }

        $this->_ci_events_class($event, $params, $object_name);
    }

    /** Load an array of events * */
    public function events($event = '', $params = NULL, $object_name = NULL)
    {
        if (is_array($event))
        {
            foreach ($event as $class)
            {
                $this->library($class, $params);
            }
        }
        return;
    }

    /**
     * Load Events
     *
     * This function loads the requested class.
     *
     * @param	string	the item that is being loaded
     * @param	mixed	any additional parameters
     * @param	string	an optional object name
     * @return	void
     */
    protected function _ci_events_class($class, $params = NULL, $object_name = NULL) {
        // Get the class name, and while we're at it trim any slashes.
        // The directory path can be included as part of the class name,
        // but we don't want a leading slash
        $class = str_replace('.php', '', trim($class, '/'));

        // Was the path included with the class name?
        // We look for a slash to determine this
        $subdir = '';
        if (($last_slash = strrpos($class, '/')) !== FALSE) {
            // Extract the path
            $subdir = substr($class, 0, $last_slash + 1);

            // Get the filename from the path
            $class = substr($class, $last_slash + 1);
        }

        // We'll test for both lowercase and capitalized versions of the file name
        foreach (array(ucfirst($class), strtolower($class)) as $class) {
            $subclass = APPPATH . 'events/' . $subdir . config_item('subclass_prefix') . $class . '.php';

            // Is this a class extension request?
            if (file_exists($subclass)) {
                $baseclass = BASEPATH . 'events/' . ucfirst($class) . '.php';

                if (!file_exists($baseclass)) {
                    log_message('error', "Unable to load the requested class: " . $class);
                    show_error("Unable to load the requested class: " . $class);
                }

                // Safety:  Was the class already loaded by a previous call?
                if (in_array($subclass, $this->_ci_loaded_files)) {
                    // Before we deem this to be a duplicate request, let's see
                    // if a custom object name is being supplied.  If so, we'll
                    // return a new instance of the object
                    if (!is_null($object_name)) {
                        $CI = & get_instance();
                        if (!isset($CI->$object_name)) {
                            return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name);
                        }
                    }

                    $is_duplicate = TRUE;
                    log_message('debug', $class . " class already loaded. Second attempt ignored.");
                    return;
                }

                include_once($baseclass);
                include_once($subclass);
                $this->_ci_loaded_files[] = $subclass;

                return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name);
            }

            // Lets search for the requested library file and load it.
            $is_duplicate = FALSE;
            foreach ($this->_ci_events_paths as $path) {
                $filepath = $path . 'events/' . $subdir . $class . '.php';

                // Does the file exist?  No?  Bummer...
                if (!file_exists($filepath)) {
                    continue;
                }

                // Safety:  Was the class already loaded by a previous call?
                if (in_array($filepath, $this->_ci_loaded_files)) {
                    // Before we deem this to be a duplicate request, let's see
                    // if a custom object name is being supplied.  If so, we'll
                    // return a new instance of the object
                    if (!is_null($object_name)) {
                        $CI = & get_instance();
                        if (!isset($CI->$object_name)) {
                            return $this->_ci_init_class($class, '', $params, $object_name);
                        }
                    }

                    $is_duplicate = TRUE;
                    log_message('debug', $class . " class already loaded. Second attempt ignored.");
                    return;
                }

                include_once($filepath);
                $this->_ci_loaded_files[] = $filepath;
                return $this->_ci_init_class($class, '', $params, $object_name);
            }
        } // END FOREACH
        // One last attempt.  Maybe the library is in a subdirectory, but it wasn't specified?
        if ($subdir == '') {
            $path = strtolower($class) . '/' . $class;
            return $this->_ci_load_class($path, $params);
        }

        // If we got this far we were unable to find the requested class.
        // We do not issue errors if the load call failed due to a duplicate request
        if ($is_duplicate == FALSE) {
            log_message('error', "Unable to load the requested class: " . $class);
            show_error("Unable to load the requested class: " . $class);
        }
    }
}
