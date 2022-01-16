<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package Codeigniter
 * @subpackage Array
 * @category Helper
 * @author Agung Dirgantara <agungmasda29@gmail.com>
 */

/**
 * Array is associated
 *
 * @param      array  $array  Array
 *
 * @return     bool   True if the array is associated, False otherwise.
 * Reference   https://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential
 */
function is_array_assoc(array $array)
{
	if (array() === $array)
	{
		return FALSE;
	}

	return array_keys($array) !== range(0, count($array) - 1);
}

/* End of file MY_array_helper.php */
/* Location : ./application/helpers/MY_array_helper.php */
