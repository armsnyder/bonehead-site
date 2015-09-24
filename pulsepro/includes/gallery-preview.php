<?php 
error_reporting(0);
include('config.php'); 
include_once("path.php"); 
?>

<!DOCTYPE html> 
<html> 

<head> 
	<title>Gallery Preview</title> 
	<meta charset="utf-8" /> 
	<link rel="stylesheet" href="#" media="all"> 
</head> 
	
<body> 

<?php if($slider_style) {include('gallery.php');} else { include('gallery2.php'); } ?>
	
</body> 
	
</html>