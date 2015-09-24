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

function add100() {
	for($i=0;$i<100;$i++) {
		$s2 = rand(0,100000000);
		$s3 = rand(0,3);
		$s4 = rand(0,400);
		$s5 = rand(0,1000);
		$s6 = rand(0,1000);
		$s7 = rand(0,99999999999);
		$s9 = rand(0,3);
		$s10 = rand(0,3);
		$s11 = rand(0,100);
		$sql = q("INSERT INTO lib_songs VALUES (NULL, $s2, $s3, $s4, $s5, $s6, $s7, NULL, $s9, $s10, $s11)");
	}
}

main();
?>