<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package Codeigniter
 * @subpackage String
 * @category Helper
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

if (!function_exists('string_to_boolean'))
{
	/**
	 * String to boolean
	 *
	 * @param 	str string
	 * @return 	boolean
	 */
	function string_to_boolean($str)
	{
		return filter_var($str, FILTER_VALIDATE_BOOLEAN);
	}
}

if (!function_exists('backslash_to_slash'))
{
	/**
	 * Backslash to slash
	 *
	 * @param  string $string
	 *
	 * @return string
	 */
	function backslash_to_slash($string)
	{
		return str_replace('\\', '/', $string);
	}
}

/* End of file MY_string_helper.php */
/* Location : ./application/helpers/MY_string_helper.php */
