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
			'sidebar_left' => 'parts/sidebar-left',
			'sidebar_right' => 'parts/sidebar-right',
			'footer' => 'parts/footer'
		), array(
			'header' => array(
				'title' => 'Medan Software'
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
}

/* End of file User.php */
/* Location : ./user/controllers/User.php */
