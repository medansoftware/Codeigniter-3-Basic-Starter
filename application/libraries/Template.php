<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template
{
	protected $ci;

	public $options = array();

	public $exclude_pages = array();

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
		$this->set_base_page((isset($config['base_page']))?$config['base_page'] : 'base'); // HTML base page
		$this->set_merge_pages((isset($config['merge_pages'])?$config['merge_pages'] : TRUE)); // merge included pages
		$this->set_return_pages((isset($config['return_pages'])?$config['return_pages'] : FALSE)); // return included pages
		$this->set_merge_vars((isset($config['merge_vars'])?$config['merge_vars'] : TRUE)); // merge vars to included pages
		$this->set_merge_vars_as_page((isset($config['merge_vars_as_page'])?$config['merge_vars_as_page'] : TRUE)); // merge vars match as included page name
		$this->set_force_merge_as_page((isset($config['force_merge_as_page'])?$config['force_merge_as_page'] : TRUE)); // force merge vars match as included page name
		$this->set_return_loaded((isset($config['return_loaded'])?$config['return_loaded'] : FALSE)); // return loaded view as string
	}

	public function set_base_page($base_page = 'base')
	{
		$this->options['base_page'] = $base_page;
		return $this;
	}

	public function set_merge_pages($merge_pages = TRUE)
	{
		$this->options['merge_pages'] = $merge_pages;
		return $this;
	}

	public function set_return_pages($return_pages = FALSE)
	{
		$this->options['return_pages'] = $return_pages;
		return $this;
	}

	public function set_merge_vars($merge_vars = TRUE)
	{
		$this->options['merge_vars'] = $merge_vars;
		return $this;
	}
	public function set_merge_vars_as_page($merge_vars_as_page = TRUE)
	{
		$this->options['merge_vars_as_page'] = $merge_vars_as_page;
		return $this;
	}
	public function set_force_merge_as_page($force_merge_as_page = TRUE)
	{
		$this->options['force_merge_as_page'] = $force_merge_as_page;
		return $this;
	}
	public function set_return_loaded($return_loaded = FALSE)
	{
		$this->options['return_loaded'] = $return_loaded;
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
		$options = array_merge($this->options, $options);

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

			$include_pages[$name] = array('file' => $file, 'vars' => $data);

			$page_num++;
		}

		if ($options['return_pages'])
		{
			return $include_pages;
		}
		else
		{
			$this->include_pages = ($options['merge_pages'])?array_merge($this->include_pages, $include_pages):$include_pages;
			return $this;
		}
	}

	/**
	 * Exclude page
	 *
	 * @param      string  $page   Page name
	 *
	 * @return     self
	 */
	public function exclude($page)
	{
		array_push($this->exclude_pages, $page);
		return $this;
	}

	/**
	 * Exclude pages
	 *
	 * @param      array  $pages  Array of pages
	 *
	 * @return     self
	 */
	public function excludes($pages)
	{
		if (!is_array($pages))
		{
			$this->exclude($pages);
			return $this;
		}

		$page_array_assoc = (!empty($pages))?array_keys($pages) !== range(0, count($pages) - 1):FALSE; // is associated array of $pages

		foreach ($pages as $name => $file)
		{
			if (!$page_array_assoc)
			{
				$name = explode('/', $file);
				$name = end($name);
			}

			$this->exclude($name);
		}

		return $this;
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
		$options = array_merge($this->options, $options);

		$merge_vars = $base_vars; // original $base_vars
		unset($base_vars['include_vars']);

		if (!empty($this->include_pages))
		{
			foreach ($this->include_pages as $name => $include)
			{
				if (in_array($name, $this->exclude_pages))
				{
					continue;
				}

				if ($options['merge_vars'])
				{
					// if $base_vars have key $include_vars
					if (isset($merge_vars['include_vars']) OR $options['force_merge_as_page'])
					{
						$include_vars = ($options['force_merge_as_page'])?$merge_vars:$merge_vars['include_vars'];

						// merge vars or force merge vars
						if ($options['merge_vars_as_page'] OR $options['force_merge_as_page'])
						{
							if (isset($include_vars[$name]))
							{
								$include['vars'] = array_merge($include['vars'], $include_vars[$name]);
							}
						}
						else
						{
							$include['vars'] = array_merge($include['vars'], $include_vars);
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

		$base_vars['_content'] = $this->ci->load->view($content, array_merge($base_vars, $page_vars), TRUE);
		$this->ci->load->view($this->options['base_page'], $base_vars, $options['return_loaded']);
	}
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */
