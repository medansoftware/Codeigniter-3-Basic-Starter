<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template
{
	protected $ci;

	public $base_page;

	public $debug = FALSE;

	public $page_vars = array();

	public $base_vars = array();

	public $include_pages = array();

	public function __construct($config = array())
	{
        $this->ci =& get_instance();
        $this->initialize($config);
	}

	/**
	 * Initialize template
	 *
	 * @param      array  $config  Library config
	 */
	public function initialize($config = array())
	{
		$this->set_base_page((isset($config['base_page']))?$config['base_page']:'base'); // HTML base page
	}

	/**
	 * Set base page
	 *
	 * @param      string  $base_page  HTML base page
	 *
	 * @return     self
	 */
	public function set_base_page($base_page)
	{
		$this->base_page = $base_page;
		return $this;
	}

	/**
	 * Include pages
	 *
	 * @param      array  $pages         Array of pages
	 * @param      array  $content_data  Content data render to page
	 * @param      array  $options       Include options
	 *
	 * @return     array
	 */
	public function includes($pages = array(), $vars =  array(), $options = array())
	{
		$default_option = array(
			'merge_page' => TRUE,
			'return_pages' => FALSE
		);

		$options = array_merge($default_option, $options);

		$include_pages = array();

		$page_num = 0;

		foreach ($pages as $name => $file)
		{
			$vars_array_assoc = (!empty($vars))?array_keys($vars) !== range(0, count($vars) - 1):FALSE; // is associated array of $vars
			$page_array_assoc = (!empty($pages))?array_keys($pages) !== range(0, count($pages) - 1):FALSE; // is associated array of $pages

			// set page name
			if (!$page_array_assoc)
			{
				$name = explode('/', $file);
				$name = end($name);
			}

			// set page vars
			$data = array();

			if (!$vars_array_assoc)
			{
				$data = array();

				if (isset($vars[$page_num]))
				{
					$data = $vars[$page_num];
				}
			}
			else
			{
				// assign vars by page name
				$data = isset($vars[$name])?$vars[$name]:$vars;
			}

			$this->page_vars = $data;

			$include_pages[$name] = array('file' => $file, 'vars' => $data);

			$page_num++;
		}

		if ($options['return_pages'])
		{
			return $include_pages;
		}
		else
		{
			$this->include_pages = ($options['merge_page'])?array_merge($this->include_pages, $include_pages):$include_pages;
			return $this;
		}
	}

	/**
	 * Load single content
	 *
	 * @param      string  $content        Content page
	 * @param      array   $options_data   Options for base page
	 * @param      array   $content_data   Option data for content page
	 * @param      bool    $return_string  Return loaded view
	 */
	public function single_content($content, $base_vars = array(), $page_vars = array(), $options = array())
	{
		$default_option = array(
			'merge_vars' => TRUE,
			'merge_vars_as_page' => TRUE,
			'return_loaded' => FALSE
		);

		$options = array_merge($default_option, $options);

		$merge_vars = $base_vars; // original $base_vars
		unset($base_vars['include_vars']);

		if (!empty($this->include_pages))
		{
			foreach ($this->include_pages as $name => $include)
			{
				if ($options['merge_vars'])
				{
					// if $base_vars have key $include_vars
					if (isset($merge_vars['include_vars']))
					{
						if ($options['merge_vars_as_page'])
						{
							if (isset($merge_vars['include_vars'][$name]))
							{
								$include['vars'] = array_merge($include['vars'], $merge_vars['include_vars'][$name]);
							}
						}
						else
						{
							$include['vars'] = array_merge($include['vars'], $merge_vars['include_vars']);
						}
					}
					else
					{
						$include['vars'] = array_merge($include['vars'], $merge_vars);
					}
				}

				$base_vars[$name] = $this->ci->load->view($include['file'], $include['vars'], TRUE);
				// $base_vars[$name] = $include; // uncomment for debug $base_vars
			}
		}

		$base_vars['content'] = $this->ci->load->view($content, array_merge($base_vars, $page_vars), TRUE);
		$this->ci->load->view($this->base_page, $base_vars, $options['return_loaded']);
	}
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */
