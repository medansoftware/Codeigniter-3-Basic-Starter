<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package Codeigniter
 * @subpackage User
 * @category HMVC Controller
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

class User extends HMVC_Controller
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
			'sidebar_left' => 'parts/sidebar-left'
		), array(
			'header' => array(
				'title' => 'Medan Software',
				'meta' => array(
					array('name' => 'description', 'content' => 'Codeigniter 3 Starter - Basic | Medan Software')
				)
			),
			'sidebar_left' => array(
				'brand' => array(
					'name' => 'Medan Software',
					'link' => site_url()
				)
			),
			'navbar' => array(
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
		$this->template->single_content('home',
			array(
				'include_vars' => array(
					'header' => array(
						'title' => 'User - Medan Software'
					)
				)
			),
			array(
				// page vars
				'page_info' => array(
					'title' => 'Dashboard',
					'breadcrumb' => array(
						array('text' => 'Home', 'link' => base_url($this->router->fetch_module())),
						array('text' => 'Dashboard', 'link' => base_url($this->router->fetch_module()))
					)
				)
			)
		);
	}
}

/* End of file User.php */
/* Location : ./user/controllers/User.php */
