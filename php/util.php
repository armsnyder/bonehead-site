<?php

require_once(__DIR__.'/../secret/passwords.php');

function initGlobals() {
	global $passwords;
	// Adds custom values to GLOBAL array and sets constants
	$GLOBALS['db'] = array(
		'server' => 'localhost',
		'user' => 'boneheads',
		'pass' => $passwords['database'],
		'database' => 'boneheads',
		'conn' => NULL,
		'connected' => false
		);
	$GLOBALS['req'] = array(
		'a' => NULL,
		'text' => NULL
	);
	$GLOBALS['c'] = array(
		'filename_len' => 6
	);
	$GLOBALS['final_print'] = array();
	$GLOBALS['post_data']=json_decode(file_get_contents('php://input'));
}

function request($str) {
	// Retrieves request data using GET over POST
	$get = $_GET[$str];
	return isset($get) ? $get : $GLOBALS['post_data']->$str;
}

function connect() {
	// Connects to mySQL database
	if($GLOBALS['db']['connected']) {
		disconnect();
	}
	$GLOBALS['db']['conn'] = new mysqli(
		$GLOBALS['db']['server'],
		$GLOBALS['db']['user'],
		$GLOBALS['db']['pass'],
		$GLOBALS['db']['database']
	);
	if ($GLOBALS['db']['conn']->connect_error) {
		die("Connection failed: " . $GLOBALS['db']['conn']->connect_error);
	}
	$GLOBALS['db']['connected'] = true;
}

function disconnect() {
	// Disconnects from mySQL database
	if($GLOBALS['db']['connected']) {
		$GLOBALS['db']['conn']->close();
		$GLOBALS['db']['connected'] = false;
	}
}

function getUniqueRandomStr($existing, $len) {
	// Generates a random string and checks against array of existing strings
	$result = NULL;
	do {
		$result = getRandomStr($len);
	} while(in_array($result, $existing));
	return $result;
}

function getRandomStr($len) {
	// Generates a random string of a specified length
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';
	for ($i = 0; $i < $len; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

function display($key,$array) {
	// Pushes array onto final output
	$GLOBALS['final_print'][$key]=$array;
}

function q($sql) {
	// Executes a sql query
	return $GLOBALS['db']['conn']->query($sql);
}

function getSqlArrayMin($sql) {
	// Formats SQL result in a column-row array and reads all rows
	$result = array('columns' => array(), 'rows' => array());
	if ($sql->num_rows > 0) {
		$fields = $sql->fetch_fields();
		foreach($fields as $val) {
			array_push($result['columns'],$val->name);
		}
		while($row = $sql->fetch_row()) {
			array_push($result['rows'],$row);
		}
	}
	return $result;
}

function getSqlArray($sql) {
	// Returns pure JSON
	$result=array();
	if ($sql->num_rows > 0) {
		while($row = $sql->fetch_assoc()) {
			array_push($result,$row);
		}
	}
	return $result;
}

function validate($text) {
	global $passwords;
	return strcmp($text, $passwords['boneheads'])==0;
}