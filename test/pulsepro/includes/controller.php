<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php
$page = $_GET['p'];

switch ($page) {
	default:
	case "":
		include("includes/blocks.php");
		break;
	
	case $page:
		
		$page = str_replace("/","", $page);
		$page = htmlspecialchars($page, ENT_QUOTES, 'UTF-8');
		
		if(file_exists("includes/".$page.".php"))
            include("includes/".$page.".php");
        else
        include("includes/404.php"); 
	
		break;
	}
?>
