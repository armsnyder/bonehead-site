<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>

<div id="sub-head">
<a href="index.php?p=settings"><?php echo $lang_nav_settings; ?></a>
</div>

<div id="content">

<link rel="stylesheet" href="css/form.css" media="all">

<p class="form-preview"><?php echo $lang_form_preview_only; ?></p>

<form id=contact method=post>

<fieldset>
<label for="name"><?php echo $lang_form_label_name; ?></label><br>
<input id="name" name="name" type="text">
</fieldset>
<fieldset>
		
<label for="email"><?php echo $lang_form_label_email; ?></label><br>
<input id="email" name="email" type="email">
</fieldset>

<fieldset>
<input id="human" name="human" type="text">  
<label for="comment"><?php echo $lang_form_label_comment; ?></label><br>
<textarea id="comment" name="comment" rows="8"></textarea>
</fieldset>

<button type="submit"><?php echo $lang_form_send; ?></button>

</form>
<ul class="form-preview-ul">
<li><?php echo $lang_form_destination_email; ?></li>
<li><?php echo $lang_form_style; ?></li>
</ul>

<div class="howto">
	<a href="javascript:doMenu('main');" id=xmain><?php echo $lang_embed; ?></a>
	<div id="main" style="display:none;">
	<p><?php echo $lang_embed_desc; ?></p>
	<input value='&lt;?php include("<?php echo $pulse_dir; ?>/includes/form.php"); ?&gt;' onclick="select_all(this)" > 
	<br><?php echo $lang_embed_desc2; ?>
	</div>
</div>

</div>