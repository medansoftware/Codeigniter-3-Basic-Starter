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
	}

	public function index()
	{
		$data['content'] = $this->load->view('home', array(), TRUE);
		$this->load->view('base', $data);
	}
}

/* End of file User.php */
/* Location : ./user/controllers/User.php */