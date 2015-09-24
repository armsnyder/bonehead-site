<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php

$domain = $_SERVER['HTTP_HOST'];

?>

<div id="sub-head">

<a href="index.php?p=manage-blog"><?php echo $lang_go_back; ?></a>

</div>

<div id="content" class="max">

<form class="editor" action="index.php?p=process" method="post" name="post">
<label><?php echo $lang_blog_label_title; ?></label>
<input class="new-title" type="text" name="subject" maxlength="70" tabindex="1" value="" />
<label><?php echo $lang_blog_label_body; ?></label>
<textarea class="block_editor" id="area2" name="message" rows="10" cols="35" wrap="virtual" style="width:450px" tabindex="2"></textarea>
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

</script>

</form>

</div>