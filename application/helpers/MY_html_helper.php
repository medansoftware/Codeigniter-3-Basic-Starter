<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package Codeigniter
 * @subpackage HTML
 * @category Helper
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

if (!function_exists('datatable'))
{
	/**
	 * DataTable HTML Generator
	 *
	 * @param      array   $class             Table CSS class
	 * @param      array   $columns           Table columns
	 * @param      bool    $search_by_column  Use search column
	 * @param      bool    $return_generate   Return generated HTML
	 *
	 * @return     string  String on $return_generate is TRUE
	 */
	function datatable($class = array(), $columns = array(), $search_by_column = TRUE, $return_generate = TRUE)
	{
		$ci =& get_instance();
		$ci->load->library('table');

		$table = array(
			'table_open' => '<table class="'.implode(' ', $class).'" cellspacing="0" width="100%">',
			'table_close' => ($search_by_column === TRUE)?'<tfoot><tr><th>'.implode('</th><th>', $columns).'</th></tr></tfoot></table>':'</table>'
		);

		$ci->table->set_template($table);
		$ci->table->set_empty('&nbsp;');
		$ci->table->set_heading($columns);

		return $ci->table->generate();
	}
}

/* End of file MY_html_helper.php */
/* Location : ./application/helpers/MY_html_helper.php */
