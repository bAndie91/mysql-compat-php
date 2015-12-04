<?php

/*
	mysql compatibility functions
 */
 
function mysql_compat_affected_rows($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_affected_rows($link);
}

function mysql_compat_client_encoding($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_character_set_name($link);
}

function mysql_compat_close($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_close($link);
}

function mysql_compat_connect($server = NULL, $username = NULL, $password = NULL, $new_link = false, $client_flags = 0)
{
	if(!isset($server)) $server = ini_get("mysql.default_host");
	if(!isset($username)) $username = ini_get("mysql.default_user");
	if(!isset($password)) $password = ini_get("mysql.default_password");
	$dbname = '';
	$socket = NULL;
	if(strpos($server, ':')>=0)
	{
		list ($host, $port) = explode(':', $server);
		if($host == '')
		{
			$host = '';
			$socket = $port;
			$port = NULL;
		}
	}
	else
	{
		$host = $server;
		$port = ini_get("mysqli.default_port");
	}
	
	$link = mysqli_connect($host, $username, $password, $dbname, $port, $socket);
	if(!$new_link)
	{
		$GLOBALS['mysql_compat_default_link'] = $link;
	}
	return $link;
}

function mysql_compat_escape_name($string)
{
	return preg_replace('/`/', '\\`', $dbname);
}

function mysql_compat_create_db($dbname, $link = NULL)
{
	return mysql_compat_query("CREATE DATABASE `" . mysql_compat_escape_name($dbname) . "`", $link);
}

function mysql_compat_data_seek($result, $row_num)
{
	return mysqli_data_seek($result, $row_num);
}

function mysql_compat_db_name($dblist_result, $row_num, $field = NULL)
{
	$seek = mysql_compat_data_seek($dblist_result, $row_num);
	if($seek)
	{
		$array = mysql_compat_fetch_assoc($dblist_result);
		if($array)
		{
			if(isset($field))
			{
				return $array[$field];
			}
			else
			{
				return $array["Database"];
			}
		}
		else
		{
			return $array;
		}
	}
	else
	{
		return $seek;
	}
}

function mysql_compat_db_query($dbname, $query, $link = NULL)
{
	$select = mysql_compat_select_db($dbname, $link);
	if($select)
	{
		return mysql_compat_query($query, $link);
	}
	else
	{
		return $select;
	}
}

function mysql_compat_drop_db($dbname, $link)
{
	return mysql_compat_query("DROP DATABASE `" . mysql_compat_escape_name($dbname) . "`", $link);
}

function mysql_compat_errno($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_errno($link);
}

function mysql_compat_error($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_error($link);
}

function mysql_compat_escape_string($string)
{
	return mysqli_escape_string($string);
}

function mysql_compat_fetch_array($result, $type)
{
	$typei = $type;
	return mysqli_fetch_array($result, $typei);
}

function mysql_compat_fetch_assoc($result)
{
	return mysqli_fetch_assoc($result);
}

function mysql_compat_fetch_field($result, $field_offset = NULL)
{
	if(isset($field_offset))
	{
		$seek = mysql_compat_field_seek($result, $field_offset);
		if(!$seek) return $seek;
	}
	return mysqli_fetch_field($result);
}

function mysql_compat_fetch_lengths($result)
{
	return mysqli_fetch_lengths($result);
}

function mysql_compat_fetch_object($result, $class_name = "stdClass", $params = array())
{
	return mysqli_fetch_object($result, $class_name, $params);
}

function mysql_compat_fetch_row($result)
{
	return mysqli_fetch_row($result);
}

function mysql_compat_field_flags($result, $field_offset)
{
	$fld = mysqli_fetch_field_direct($result, $field_offset);
	if(!$fld) return $fld;
	return $fld->flags;
}

function mysql_compat_field_len($result, $field_offset)
{
	$fld = mysqli_fetch_field_direct($result, $field_offset);
	if(!$fld) return $fld;
	return $fld->length;
}

function mysql_compat_field_name($result, $field_offset)
{
	$fld = mysqli_fetch_field_direct($result, $field_offset);
	if(!$fld) return $fld;
	return $fld->name;
}

function mysql_compat_field_seek($result, $field_offset)
{
	return mysqli_field_seek($result, $field_offset);
}

function mysql_compat_field_table($result, $field_offset)
{
	$fld = mysqli_fetch_field_direct($result, $field_offset);
	if(!$fld) return $fld;
	return $fld->table;
}

function mysql_compat_field_type($result, $field_offset)
{
	$fld = mysqli_fetch_field_direct($result, $field_offset);
	if(!$fld) return $fld;
	return $fld->type;
}

function mysql_compat_free_result($result)
{
	return mysqli_free_result($result);
}

function mysql_compat_get_client_info($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_get_client_info($link);
}

function mysql_compat_get_host_info($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_get_host_info($link);
}

function mysql_compat_get_proto_info($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_get_proto_info($link);
}

function mysql_compat_get_server_info($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_get_server_info($link);
}

function mysql_compat_info($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_info($link);
}

function mysql_compat_insert_id($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_insert_id($link);
}

function mysql_compat_list_dbs($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysql_compat_query("SHOW DATABASES", $link);
}

function mysql_compat_list_fields($dbname, $tname, $link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysql_compat_query("SHOW COLUMNS FROM `".mysql_compat_escape_name($dbname)."`.`".mysql_compat_escape_name($tname)."`", $link);
}

function mysql_compat_list_processes($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysql_compat_query("SHOW PROCESSLIST", $link);
}

function mysql_compat_list_tables($dbname, $link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysql_compat_query("SHOW TABLES FROM `".mysql_compat_escape_name($dbname)."`", $link);
}

function mysql_compat_num_fields($result)
{
	return mysqli_num_fields($result);
}

function mysql_compat_num_rows($result)
{
	return mysqli_num_rows($result);
}

function mysql_compat_pconnect($server = NULL, $username = NULL, $password = NULL, $client_flags = 0)
{
	if(!isset($server)) $server = ini_get("mysql.default_host");
	if(!isset($username)) $username = ini_get("mysql.default_user");
	if(!isset($password)) $password = ini_get("mysql.default_password");
	$dbname = '';
	$socket = NULL;
	if(strpos($server, ':')>=0)
	{
		list ($host, $port) = explode(':', $server);
		if($host == '')
		{
			$host = '';
			$socket = $port;
			$port = NULL;
		}
	}
	else
	{
		$host = $server;
		$port = ini_get("mysqli.default_port");
	}
	
	if(isset($GLOBALS['mysql_compat_persistent_link'][$server][$username][$password]))
	{
		return $GLOBALS['mysql_compat_persistent_link'][$server][$username][$password];
	}

	$link = mysqli_connect("p:".$host, $username, $password, $dbname, $port, $socket);
	$GLOBALS['mysql_compat_persistent_link'][$server][$username][$password] = $link;
	return $link;
}

function mysql_compat_ping($link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_ping($link);
}

function mysql_compat_query($query, $link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_query($link, $query);
}

function mysql_compat_real_escape_string($string, $link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_real_escape_string($link, $string);
}

function mysql_compat_result($result, $row_num, $field_def = 0)
{
	$dseek = mysql_compat_data_seek($result, $row_num);
	if(!$dseek) return $dseek;
	if(is_numeric($field_def))
	{
		$field_num = $field_def;
	}
	else
	{
		$field_num =
	}
	return mysql_compat_fetch_field($result, $field_num);
}

function mysql_compat_select_db($dbname, $link = NULL)
{
	if(!isset($link)) $link = $GLOBALS['mysql_compat_default_link'];
	return mysqli_select_db($link, $dbname);
}

function mysql_compat_set_charset()
{
}

function mysql_compat_stat()
{
}

function mysql_compat_tablename()
{
}

function mysql_compat_thread_id()
{
}

function mysql_compat_unbuffered_query()
{
}
