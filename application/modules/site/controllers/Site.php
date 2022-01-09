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
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}
}

/* End of file Site.php */
/* Location : ./site/controllers/Site.php */
