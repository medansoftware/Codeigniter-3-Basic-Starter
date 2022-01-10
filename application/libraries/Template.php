<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template
{
	protected $ci;

	protected $base_page;

	protected $include_pages;

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
	public function include($pages = array(), $content_data =  array(), $options = array())
	{
		$default_options = array(
			'return' => FALSE, // return array of included pages
			'merge_include_pages' => FALSE, // merge with $this->include_pages
			'return_loaded_view' => TRUE // return loaded view
		);

		$options = array_merge($default_options, $options); // merge with $default_options
		$include_pages = array(); // define for included pages

		$is_array_assoc = (!empty($pages))?array_keys($pages) !== range(0, count($pages) - 1):FALSE; // is array assoc $pages

		foreach ($pages as $name => $page)
		{
			if (!$is_array_assoc)
			{
				$name = explode('/', $page);
				$name = end($name);
			}

			$include_pages[$name] = $this->ci->load->view($page, $content_data, $options['return_loaded_view']);
		}

		$this->include_pages = ($options['merge_include_pages'])?array_merge($this->include_pages, $include_pages):$include_pages;

		return ($options['return'])?$include_pages:$this;
	}

	/**
	 * Load single content
	 *
	 * @param      string  $content        Content page
	 * @param      array   $options_data   Options for base page
	 * @param      array   $content_data   Option data for content page
	 * @param      bool    $return_string  Return loaded view
	 */
	public function single_content($content, $options_data = array(), $content_data = array(), $return_string = FALSE)
	{
		if (!empty($this->include_pages))
		{
			foreach ($this->include_pages as $name => $html)
			{
				$options_data[$name] = $html;
			}
		}

		$options_data['content'] = $this->ci->load->view($content, array_merge($options_data, $content_data), TRUE);
		$this->ci->load->view($this->base_page, $options_data, $return_string);
	}
}

/* End of file Template.php */
/* Location: ./application/libraries/Template.php */
