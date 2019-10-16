<?php


class db_sql{
	public $db;
	public $d_select_count;
	public $d_select;
	public $error;

	function __construct()
	{
		GLOBAL $db;
		$this->db = mysql_connect($db['host'], $db['user'], $db['pass']);
		mysql_select_db($db['name'], $this->db);
		mysql_query('set character_set_client="utf8"');
		mysql_query('set character_set_results="utf8"');
		$this->d_select_count = - 1;
		$this->d_select_count_queries = 0;
		$this->error = false;
	}

	function __destruct()
	{
		mysql_close($this->db);
	}

	public function db_sql_select($what, $table, $other = '')
	{
		$this->d_select_count = 0;
		$this->error = false;
		if($what == '') $what = '*';
		if($table == '') return false;
		if($what == 'count(*)') $what = 'count(*) as coun';
		if($this->d_select = mysql_query('SELECT '.$what.' FROM '.$table.' '.$other, $this->db))
		{
			if($what == 'count(*) as coun')
			{
				$rows = mysql_fetch_array($this->d_select);
				$this->d_select_count = $rows['coun'];
				$this->d_select_count_queries++;
				return true;
			}
			else
			{
				$this->d_select_count = mysql_num_rows($this->d_select);
				$this->d_select_count_queries++;
				return true;
			}
		}
		else
		{
			$this->error = mysql_error($this->db);
			return false;
		}
	}

	public function db_sql_update($table, $set, $where)
	{
		if($table == '') return false;
		if($set == '') return false;
		if(mysql_query('UPDATE '.$table.' SET '.$set.' '.$where, $this->db))
		{
			$this->d_select_count_queries++;
			return true;
		}
		else
		{
			$this->error = mysql_error($this->db);
			return false;
		}
	}

	public function db_sql_delete($table, $where)
	{
		if($table == '') return false;
		if(mysql_query("DELETE FROM ".$table." ".$where, $this->db))
		{
			$this->d_select_count_queries++;
			return true;
		}
		else
		{
			$this->error = mysql_error($this->db);
			return false;
		}
	}

	public function db_sql_insert($table, $values, $duplicate = '')
	{
		if($table == '') return false;
		if($values == '') return false;
		if($duplicate != '')			$duplicate = ' ON DUPLICATE KEY UPDATE '.$duplicate;
		if(mysql_query("INSERT INTO ".$table." VALUES(".$values.")".$duplicate, $this->db))
		{
			$this->d_select_count_queries++;
			return true;
		}
		else
		{
			$this->error = mysql_error($this->db);
			return false;
		}
	}

	public function escape_string($str)
	{
		if(get_magic_quotes_gpc())			$str = stripslashes($str);
		$str = str_replace("\r", '', $str);
		$str = str_replace("\n", '', $str);
		$str = str_replace("\\", '', $str);
		$str = str_replace("~", '', $str);
		$str = str_replace("'", '&#39;', $str);
		return mysql_real_escape_string($str);
	}
	
	public function last_insert(){
		return mysql_insert_id($this->db);
	}
}
?>