<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php 

$domain = $_SERVER['HTTP_HOST'];

$post_id = $_REQUEST['post_id'];
$page = htmlspecialchars($page, ENT_QUOTES, 'UTF-8');

$opFile = "data/blog/blogfile.txt";

$fp = fopen($opFile,"r") or die("$lang_blog_error_reading"); 

$data = @fread($fp, filesize($opFile));
fclose($fp);

$line = explode("\n", $data);
			
$no_of_posts = count($line)-1;

for ($i=0; $i<$no_of_posts; $i++){
	$blog = explode("|", $line[$i]);
	if($blog[0] != $post_id) continue;
	if ($blog[0] == $post_id){
		
		$post_comment = $blog[1];
        $edit_post_date = $blog[2];
        $edit_post_title = $blog[3];
        $edit_post_content = $blog[4];
		break;
	}
}
?> 

<div id="sub-head">

<a href="index.php?p=manage-blog"><?php echo $lang_go_back; ?></a>

</div>

<div id="content" class="max">

<form class="editor" id="edit_post" method="post" action="index.php?p=update-post">
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>" />
    <input type="hidden" name="post_comment" value="<?php echo $post_comment; ?>" />
    <input type="hidden" name="post_date" value="<?php echo $edit_post_date; ?>" />
	<label><?php echo $lang_blog_label_title; ?></label>
	<input cols="100" class="new-title" type="text" name="title" value="<?php echo $edit_post_title; ?>" />
	<label><?php echo $lang_blog_label_body; ?></label>
	<textarea class="block_editor" id="area2" cols="100" rows="10" name="content"><?php echo $edit_post_content; ?></textarea>
	<script type="text/javascript">
			
	CKEDITOR.replace( 'area2', {
						
		toolbar:
		[
		['Save'],
        ['Bold','Italic'],
        ['NumberedList','BulletedList'],
        ['JustifyLeft','JustifyCenter','JustifyRight'],
        ['Link'],
        ['Image'],
        ['Format'],
        ['Table'],['Maximize'],['RemoveFormat'],['Source'],['More']
        ]        
			
		});

	</script><br>
	
   </form>

<h2 class="comments-header"><?php echo $lang_blog_num_comment; ?></h2>

<?php 

$filename = "data/blog/comments.txt";

$fp = fopen($filename, "r") or die("$lang_blog_error_reading");
$data = @fread($fp, filesize($filename));
fclose($fp);

$line = explode("\n", $data);

$nb = count($line);
for($i=0; $i < $nb; $i++) { 
	$blog = explode("|", $line[$i]);
	if($blog[0] == $post_id) {
	   $date = explode( ' ' , $blog[1]);
	   $date = $date[2] . '-' . $date[1]  . '-' . $date[3];
	    echo "<div class=\"comments-list\">
	    	  <span class=\"comment-title\">". $blog[2]." (". $blog[3].")</span> | <span >$date</span> | 
	    	  <a href=\"index.php?p=del-post&comment_id=";
	    echo  $i+1;
	    echo "&post_id=";
	    echo  $post_id;
	    echo "\" class=\"del-but\">$lang_blog_comment_delete</a>"; 
	    echo "</div>";
	
	}

}
?>
</div>