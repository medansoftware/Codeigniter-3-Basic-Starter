<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	private $last_query = array();

	private $database;

	private $table;

	public function __construct()
	{
		parent::__construct();

		if (empty($this->database))
		{
			$this->set_database(CURRENT_DATABASE_GROUP);
		}
	}

	/**
	 * Set current database
	 *
	 * @param      string  $group  Database group name
	 *
	 * @return     self
	 */
	public function set_database($group)
	{
		$this->database = $this->load->database($group, TRUE);
		return $this;
	}

	/**
	 * Get tables of database
	 *
	 * @return     array  Database tables
	 */
	public function get_tables()
	{
		$this->last_query();
		return $this->database->list_tables();
	}

	/**
	 * Check database table is exists
	 *
	 * @param      string  $table  Table name
	 *
	 * @return     boolean  True if table exists, False otherwise.
	 */
	public function table_exists($table)
	{
		$this->last_query();
		return $this->database->table_exists($table);
	}

	/**
	 * Set table
	 *
	 * @param      string  $name   Database table name
	 *
	 * @return     self
	 */
	public function set_table($name)
	{
		$this->table = $name;
		return $this;
	}

	/**
	 * Get fields of table
	 *
	 * @param      string  $table  Table name
	 *
	 * @return     array   Table fields
	 */
	public function get_fields($table)
	{
		if ($this->database->table_exists($table))
		{
			$this->last_query();
			return $this->database->list_fields($table);
		}

		return FALSE;
	}

	/**
	 * Check table field exists
	 *
	 * @param      string  $table  Table name
	 * @param      string  $field  Field name
	 *
	 * @return     bool  True if field exists, False otherwise.
	 */
	public function field_exists($table, $field)
	{
		$this->last_query();
		if ($this->table_exists($table))
		{
			return $this->database->field_exists($field, $table);
		}

		return FALSE;
	}

	/**
	 * Last queries
	 *
	 * @return     array
	 */
	public function last_query()
	{
		if (!empty($this->database))
		{
			$last_query = $this->database->last_query();
			$this->database->reset_query();
			(!empty($last_query))?array_push($this->last_query, str_replace("\n", '', $last_query)):FALSE;
		}

		return $this->last_query;
	}

	/**
	 * Insert table data
	 *
	 * @param      array   	$data       Data to insert
	 * @param      bool  	$return_id  Return inserted ID
	 *
	 * @return     bool|int
	 */
	public function create($data = array(), $return_id = FALSE)
	{
		$this->last_query();
		$query = $this->database->insert($this->table, $data);
		$insert_id = $this->database->insert_id();

		if ($return_id)
		{
			return ($query)?$insert_id:$query;
		}
		else
		{
			return $query;
		}
	}

	/**
	 * Read table data
	 *
	 * @param      array   	$where   Where query
	 * @param      int  	$limit   Query limit
	 * @param      int     	$offset  Query offset
	 *
	 * @return     Query result
	 */
	public function read($where = array(), $limit = NULL, $offset = 0)
	{
		$this->last_query();
		(!empty($where))?$this->database->where($where):FALSE;
		(!empty($limit))?$this->database->limit($limit, $offset):FALSE;

		if (!empty($limit))
		{
			$this->database->limit($limit, $offset);
		}

		return $this->database->get($this->table);
	}

	/**
	 * Update table data
	 *
	 * @param      array   $data   Data to update
	 * @param      array   $where  Where query
	 *
	 * @return     bool
	 */
	public function update(array $data, $where = array())
	{
		$this->last_query();
		if (!empty($where))
		{
			$this->database->where($where);
		}

		return $this->database->update($this->table, $data);
	}

	/**
	 * Delete table data
	 *
	 * @param      array   $where  Where query
	 *
	 * @return     bool
	 */
	public function delete($where = array())
	{
		$this->last_query();
		if (!empty($where))
		{
			$this->database->where($where);
		}

		return $this->database->delete($this->table);
	}

	/**
	 * Count table data
	 *
	 * @param      array   $where  Where query
	 *
	 * @return     int
	 */
	public function count($where = array())
	{
		$this->last_query();
		if (!empty($where))
		{
			$this->database->where($where);
		}

		return $this->database->count_all_results($this->table);
	}
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */