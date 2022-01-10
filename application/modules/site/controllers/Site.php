<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package Codeigniter
 * @subpackage Site
 * @category HMVC Controller
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

class Site extends HMVC_Controller
{
	/**
	 * constructor
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('template');
		$this->template->includes(array(
			'header' => 'parts/header',
			'navbar' => 'parts/navbar',
			'footer' => 'parts/footer'
		), array(
			'header' => array(
				'title' => 'Medan Software',
				'meta' => array(
					array('name' => 'description', 'content' => 'Codeigniter 3 Starter - Basic | Medan Software')
				)
			),
			'navbar' => array(
				'brand' => array(
					'name' => 'Medan Software',
					'link' => site_url()
				),
				'menus' => array(
					array('link' => base_url($this->router->fetch_module()), 'name' => 'index', 'text' => 'Home'),
					array('link' => base_url($this->router->fetch_module().'/about'), 'name' => 'about', 'text' => 'About')
				)
			),
			'footer' => array(
				'copyright' => 'Medan Software'
			)
		));
	}

	public function index()
	{
		$this->template->single_content('home');
	}

	public function about()
	{
		$this->template->single_content('about',
			// base vars
			array(
				'include_vars' => array(
					'header' => array(
						'title' => 'About - Medan Software'
					)
				)
			),
			array(
				// page vars
				'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
			),
			//  method options
			array(
				'merge_vars' => TRUE,
				'merge_vars_as_page' => TRUE,
				'return_loaded' => FALSE
			)
		);
	}
}

/* End of file Site.php */
/* Location : ./site/controllers/Site.php */
