<?
header('Access-Control-Allow-Origin: *');
header('content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

require_once(__DIR__.'/../secret/passwords.php');

function main() {
	init();
	connect();
	switch($GLOBALS['req']['a']) {
		case 'getMembers':
			display('members', getMembers());
			break;
	}
	echo json_encode($GLOBALS['final_print']);
	disconnect();
}

function getMembers() {
	$curYear = date('Y');
	$sql = $GLOBALS['db']['conn']->query("SELECT * FROM meet_us_members");
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

function addMember() {

}

function init() {
	global $passwords;
	$GLOBALS['db'] = array(
		'server' => 'localhost',
		'user' => 'boneheads',
		'pass' => $passwords['database'],
		'database' => 'boneheads',
		'conn' => NULL,
		'connected' => false
		);
	$GLOBALS['req'] = array(
		'a' => NULL
	);
	$GLOBALS['final_print'] = array();
	$GLOBALS['post_data']=json_decode(file_get_contents('php://input'));
	foreach($GLOBALS['req'] as $key => $val) {
		$GLOBALS['req'][$key] = isset($_GET[$key]) ? $_GET[$key] : $GLOBALS['post_data']->$key;
	}
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

function display($key,$array) {
	// Pushes array onto final output
	$GLOBALS['final_print'][$key]=$array;
}

main();
?>