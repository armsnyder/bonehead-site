<?php
header('content-type: application/json; charset=utf-8');

require_once('util.php');

function main() {
	init();
	switch($GLOBALS['req']['a']) {
		case 'getSongs':
			connect();
			display('songs', getSongs());
			break;
		case 'getSongsMin':
			connect();
			display('songsMin', getSongsMin());
			break;
		case 'add100':
			add100();
			display('done',0);
			break;
		case 'getMembers':
			connect();
			display('members', getMembers());
			break;
		case 'validate':
			display('valid', validate($GLOBALS['req']['text']));
			break;
        case 'addMember':
            connect();
            addMember();
            break;
		case 'getNewImageName':
            connect();
			display('done', getNewImageName());
            break;
        case 'uploadPicture':
            connect();
            uploadPicture();
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

function addMember() {
    $formData = $GLOBALS['req']['form'];
    if ($formData==null) {
        signalError('No form data');
        return;
    }
    if (!array_key_exists('password', $formData) || !validate($formData->password)) {
        signalError('Bad password');
        return;
    }
    $relevantFields = array(
        'name', 'gov_name', 'major', 'year', 'height', 'tv', 'food', 'joined',
        'memory', 'underwear', 'talent', 'color', 'picture');
    if (array_key_exists('id', $formData)) {
        updateMember($formData, $relevantFields);
    } else {
        addNewMember($formData, $relevantFields);
    }
//    trashUnusedPhotos(array());
}

function addNewMember($formData, $relevantFields) {
    $gov_name = str_replace("'", "\\'", $formData->gov_name);
    $sql = q("SELECT * FROM meet_us_members WHERE gov_name='$gov_name'");
    if ($sql->num_rows!=0) {
        signalError('Failed to add bio - duplicate government name detected.');
        return;
    }
    $keyStr = join(', ', $relevantFields);
    $set = array();
    foreach($relevantFields as $key) {
        if (!array_key_exists($key, $formData)) {
            signalError('Invalid form data');
            return;
        }
        $escapedVal = str_replace("'", "\\'", $formData->$key);
        if ($key=='year') {
            array_push($set, $escapedVal);
            continue;
        }
        array_push($set, "'".$escapedVal."'");
    }
    $setStr = join(', ', $set);
    $queryStr = "INSERT INTO meet_us_members ($keyStr) VALUES ($setStr)";
    $sql = q($queryStr);
    if (!$sql) {
        signalError('Failed to update database: '.$GLOBALS['db']['conn']->error);
        return;
    }
    display('success', 'yay');
    file_put_contents ('log.txt', $queryStr."\r\n", FILE_APPEND);
}

function updateMember($formData, $relevantFields) {
    $id = $formData->id;
    $gov_name = str_replace("'", "\\'", $formData->gov_name);
    $sql = q("SELECT * FROM meet_us_members WHERE id=$id and gov_name='$gov_name'");
    if ($sql->num_rows!=1) {
        signalError('Failed to update bio - could not find database entry (found '.$sql->num_rows.")");
        return;
    }
    $set = array();
    foreach($relevantFields as $key) {
        if (!array_key_exists($key, $formData)) {
            signalError('Invalid form data');
            return;
        }
        $escapedVal = str_replace("'", "\\'", $formData->$key);
        if ($key=='year') {
            array_push($set, $key.'='.$escapedVal);
            continue;
        }
        array_push($set, $key.'='."'".$escapedVal."'");
    }
    $setStr = join(', ', $set);
    $queryStr = "UPDATE meet_us_members SET $setStr WHERE id=$id and gov_name='$gov_name'";
    $sql = q($queryStr);
    if (!$sql) {
        signalError('Failed to update database: '.$GLOBALS['db']['conn']->error);
        return;
    }
    display('success', 'yay');
    file_put_contents ('log.txt', $queryStr."\r\n", FILE_APPEND);
}

function signalError($text) {
    display('error', $text);
}

function uploadPicture() {
    $res = saveFile(getNewImageName(), 1000000);
    if (array_key_exists('error', $res)) {
        display('error', $res['error']);
    } elseif (array_key_exists('success', $res)) {
        display('success', $res['success']);
        $uploadedFile = $res['success'];
//        trashUnusedPhotos(array($uploadedFile=>null));
    }
}

function trashUnusedPhotos($whiteList) {
    $allImages = array_merge(getAllImageNamesFull(), $whiteList);
    $uploadsPath = __DIR__.'/../uploads/';
    $trashPath = __DIR__.'/../trash/';
    $dir = new DirectoryIterator($uploadsPath);
    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isDot()) {
            $fileName = $fileinfo->getFilename();
            if (!array_key_exists($fileName, $allImages)) {
                if (copy($uploadsPath.$fileName, $trashPath.$fileName)) {
                    unlink($uploadsPath.$fileName);
                }
            }
        }
    }
}

main();