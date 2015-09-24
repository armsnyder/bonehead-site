<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>

<div id="sub-head">
<a href="index.php?p=post" class="top-btn"><?php echo $lang_blog_new_post; ?></a>
<a target="_blank" href="<?php echo $blog_url ?>" class="top-btn"><?php echo $lang_blog_preview; ?> &rarr;</a>
</div>

<div id="content">

<?php

$opFile = "data/blog/blogfile.txt";

$fp = fopen($opFile,"r") or die("$lang_blog_error_reading"); 

  while (!feof($fp)) {
	  
	  $posts[] = fgets($fp);
  }
fclose($fp); 

$no_of_posts = count($posts)-1;

$records = $no_of_posts;
if($records) 
{
	$result_per_page = 5 ;
	$total_pages = ceil($records/$result_per_page);

	$cur_page = $_GET[page] ? $_GET[page] : 1; 

	$start = $records -(($cur_page-1) * $result_per_page);
	$end = $records -(($cur_page) * $result_per_page);
	
	echo "<table class=\"blog-list\">\n";

	for ($n=$start-1  ;  $n>=$end  ;  $n-- ) { 

	  $blog = explode("|", $posts[$n]);
	  $date = explode( ' ' , $blog[2]);
	  $date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];

	  if (isset($blog[0]) && $blog[0] != '') 
	   { 
	   	 $post_id = $n+1;
		 
		 echo "<tr>\n";
		 echo "<td class=\"col-name\"><a class=\"admin-blog-title\" href=\"index.php?p=edit-post&post_id=" . $blog[0] . "\">$blog[3]</a></td>\n";
		 echo "<td class=\"col-edit\" ><a href=\"index.php?p=edit-post&post_id=" . $blog[0] . "\"  class=\"edit-but\" >$lang_blog_post_edit</a></td>\n";
		 echo "<td class=\"col-delete\" ><a href=\"index.php?p=del-post&post_id=". $blog[0] ."\" class=\"del-but\">$lang_blog_post_delete</a></td>\n";
		 echo "</tr>\n\n";
	   }
	   else{
		 continue;   
	   }
	}  
	
	echo "</table>\n\n";
	
	echo "<div class=\"clear\">&nbsp;</div>\n";

	echo "<div class=\"blog-pagination\">";

	if ($cur_page<$total_pages){
	
		echo '<a class="older" href=index.php?p=manage-blog&page=' . ($cur_page+1) . '>' . $lang_blog_older . '</a>' . '&nbsp;&nbsp;&nbsp;';
	}

	if ($cur_page>1) {
	
		echo  '<a class="newer" href=index.php?p=manage-blog&page=' . ($cur_page-1) . '>' . $lang_blog_newer . '</a>';
	}

	echo "&nbsp;</div>";
}
else
{
	echo "<p>$lang_blog_no_post</p>";

}
?>

<div class="clear"></div>

<div class="howto">
	<a href="javascript:doMenu('main');" id=xmain><?php echo $lang_embed; ?></a>
	<div id="main" style="display:none;">
	<p><?php echo $lang_embed_desc; ?></p>
	<p><b><?php echo $lang_blog_main_embed; ?></b></p>
	<input value='&lt;?php include("<?php echo $pulse_dir; ?>/includes/blog.php"); ?&gt;' onclick="select_all(this)" >
	<p><b><?php echo $lang_blog_recent_embed; ?></b></p>
	<input value='&lt;?php include("<?php echo $pulse_dir; ?>/includes/recent.php"); ?&gt;' onclick="select_all(this)" > 
	
	<br><?php echo $lang_embed_desc2; ?>
	</div>
</div>

</div>