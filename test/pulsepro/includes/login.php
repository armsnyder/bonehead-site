<?php
ob_start();
session_start();
$max_session_time = 36000;
$cmp_pass = Array();
$cmp_pass[] = md5($pulse_pass);
$max_attempts = 10;
$session_expires = $_SESSION["mpass_session_expires"];
$max_attempts++;

function checkIfCookieExists(){
	if( isset($_COOKIE["mpass_pass"]) ){
		$_SESSION["mpass_pass"] = $_COOKIE['mpass_pass'];
	}
}

checkIfCookieExists();

if(!empty($_POST["mpass_pass"])){
	if( in_array(md5($_POST["mpass_pass"]), $cmp_pass) ){
		$_SESSION["mpass_pass"] = md5($_POST["mpass_pass"]);
		setcookie ("mpass_pass", md5($_POST["mpass_pass"]), time()+3600*24*7,'/');
		header("Location: index.php");
	}
}

if(empty($_SESSION["mpass_attempts"])){
	$_SESSION["mpass_attempts"] = 0;
}

if(($max_session_time>0 && !empty($session_expires) && time()>$session_expires) || empty($_SESSION["mpass_pass"]) || !in_array($_SESSION["mpass_pass"],$cmp_pass)){
	
	if(!in_array($_SESSION["mpass_pass"],$cmp_pass)){
		$_SESSION["mpass_attempts"]++;
	}
	
	if($max_attempts>1 && $_SESSION["mpass_attempts"]>=$max_attempts){
		exit("Too many login failures.");
	}

	$_SESSION["mpass_session_expires"] = "";
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $lang_page_title; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <link rel="stylesheet" href="css/style.css" media="all">
</head>

<body id="login-page">
    <div id="top">
    
    <form name="login" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="login">
    <img src="img/logo-full.png" />
    	<?php
			if (!empty($_POST["mpass_pass"]) && !in_array(md5($_POST["mpass_pass"]), $cmp_pass))
			echo "<p class=\"errorMsg\">$lang_login_incorrect</p>"; ?>
        <input type="password" size="27" name="mpass_pass" placeholder="Password" autofocus>
        <button type="submit"><?php echo $lang_login_button; ?></button>
    </form>
    </div>
</body>
</html>
<?php 
exit();
}
$_SESSION["mpass_attempts"] = 0;
$_SESSION["mpass_session_expires"] = time()+$max_session_time;
?>