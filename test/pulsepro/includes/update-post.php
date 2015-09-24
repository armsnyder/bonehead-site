<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<div id="sub-head">
<a href="index.php?p=manage-blog"><?php echo $lang_go_back; ?></a>
</div>
<?php 

$id = $_POST['post_id'];
$comments = $_POST['post_comment'];
$date = $_POST['post_date'];
$title = htmlspecialchars(trim(stripslashes($_POST['title'])), ENT_QUOTES, "UTF-8");
$content = strip_tags(stripslashes($_POST['content']), "<p><center><u><strong><audio><link><iframe><object><fieldset><dl><dt><dt><colgroup><col><font><label><em><embed><a><pre><b><i><style><table><tbody><td><textarea><tfoot><th><thead><title><tr><tt><ul><li><ol><img><h1><h2><h3><h4><h5><hr><address><span><div><blockquote><br><br /><button>");
$content = str_replace("\n", "", $content);
$content = str_replace("\r", "", $content);

$opFile = "data/blog/blogfile.txt";

$fp = @fopen($opFile,"r") or die("$lang_blog_error_reading"); 
$data = @fread($fp, filesize($opFile));
fclose($fp);

$line = explode("\n", $data);			
$no_of_posts = count($line)-1;

for ($i=0; $i<$no_of_posts; $i++){
	$blog = explode("|", $line[$i]);

	if($blog[0] == $id) {	
		$new_data .=  $id .'|'.$comments.'|'.$date . '|' . $title . '|' . $content . "\n";
	}else{
		$new_data .= $line[$i] . "\n";
	}
}


$file = @fopen($opFile,"w") or die($lang_blog_error_reading); 
$success = fwrite($file, $new_data);
fclose($file); 

echo "<div id=\"content\">";
echo "<p class=\"green\">$lang_blog_post_updated</p>";
echo "</div>";
?>
