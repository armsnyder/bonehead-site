<?
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true"); 
             header('Access-Control-Allow-Headers: X-Requested-With');
             header('Access-Control-Allow-Headers: Content-Type');
             header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');
             header('Access-Control-Max-Age: 86400'); 
header("Content-Type: application/json; charset=UTF-8");

require('util.php');

function main() {
	init();
	connect();
	switch($GLOBALS['req']['a']) {
		case 'getSongs':
			display('songs', getSongs());
			break;
		case 'getSongsMin':
			display('songsMin', getSongsMin());
			break;
		case 'add100':
			add100();
			display('done',0);
			break;
		case 'getMembers':
			display('members', getMembers());
			break;
	}
	echo json_encode($GLOBALS['final_print']);
	disconnect();
}

function init() {
	initGlobals();
	foreach($GLOBALS['req'] as $key => $val) {
		$GLOBALS['req'][$key] = request($key);
	}
}

function getSongs() {
	// Queries the song database and returns all results
	$sql = q("SELECT * FROM lib_songs");
	return getSqlArray($sql);
}

function getSongsMin() {
	// Queries the song database and returns all results
	$sql = q("SELECT * FROM lib_songs");
	return getSqlArrayMin($sql);
}

function getMembers() {
	$curYear = date('Y');
	$sql = q("SELECT * FROM meet_us_members");
	$result=array('current'=>array(),'alums'=>array());
	if ($sql->num_rows > 0) {
		while($row = $sql->fetch_assoc()) {
			if($row['year']<=$curYear || $row['dropout']==1) {
				array_push($result['alums'],$row);
			} else {
				array_push($result['current'],$row);
			}
		}
	}
	return $result;
}

main();
?>