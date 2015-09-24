<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php
error_reporting(0);
include_once("config.php"); 
include_once("path.php");

if($pulse_lang == 0){
include_once("lang.php");}
else
if($pulse_lang == 1){
include_once("lang_de.php");}

$domain = $_SERVER['HTTP_HOST'];
?>

<?php

$opFile =  ROOTPATH . "/data/blog/blogfile.txt";

$fp = fopen($opFile, "r") or die("Error Reading File");
$data = @fread($fp, filesize($opFile));
fclose($fp);

if(!empty($_GET["d"]) && is_numeric($_GET["d"])) {
$id_post = $_GET["d"];

include("clean_url.php");

?>

<?php

} else {
	$line = explode("\n", $data);
	$records = count($line)-1;
	$result_per_page = 3 ;
	$cur_page = $_GET[page] ? $_GET[page] : 1;
	$start = $records - (($cur_page-1) * $result_per_page);
	$end = $records - (($cur_page) * $result_per_page);

	echo "<div class=\"latest-posts\">\n\n";
        			
	for ($n=$start-1  ;  $n>=$end  ;  $n-- ) { 
		$blog = explode("|", $line[$n]);
		
		if (isset($blog[0]) & $blog[0] != '') {
			
			$date = explode( ' ' , $blog[2]);
			$date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];
			
			include("clean_url.php");
			
			if($rewrite) {
			    echo "<p><a href=\"/blog-". $blog[0] ."-$clean_url\">" .$blog[3]. "</a> (" .$blog[1]. ")<br>";
			} else {
		        echo "<p><a href=\"". $blog_url ."?d=". $blog[0] ."\">" .$blog[3]."</a> (" .$blog[1]. ")<br>";
			}
			
			if($date_format) {
				echo date("d-m-Y", strtotime($date))."</p>\n\n";
			} else {
				echo date("m-d-Y", strtotime($date))."</p>\n\n";
			} 
					
					}
	}
	}

	echo "<p class=\"all-posts\"><a href=\"". $blog_url ."\">$lang_blog_see_all</a></p>";

echo "\n\n</div>";
?>