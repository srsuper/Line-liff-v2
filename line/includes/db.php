<?php

function connect_db() {
	global $DB_CONNECTION;
	
	if (!isset($DB_CONNECTION)) {
		$DB_CONNECTION = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Cannot connect to the database because ".mysql_error());
		mysql_select_db(DB_NAME);
	}
}

function disconnect_db() {
	global $DB_CONNECTION;
	
	if (isset($DB_CONNECTION)) {
		mysql_close($DB_CONNECTION);
	}
}

function run_query($query) {
	global $DB_CONNECTION;

	@mysql_query("set names utf8");
	$result = @mysql_query($query, $DB_CONNECTION);
	
	if (!$result) {
		$track = debug_backtrace();
		$error_msg = mysql_error();
	
		if (DEBUG) {
			$error_msg .= "<br/><br/>".$query."<br/><br/>In file ".$_SERVER["PHP_SELF"]."<br/><br/>On line: ".$track[0]["linie"];
		}
	
		die($error_msg);
			
	} else {
		return $result;
	}
}

?>