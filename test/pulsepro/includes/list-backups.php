<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<div id="sub-head">
<a href="index.php?p=backup"><?php echo htmlentities($lang_backup_now); ?></a>
</div>

<div id="content">
	            
<div class="backup-list">
	
	<?php 
	
	$files = glob("data/backups/*");
	if( $files) {
	foreach ($files as $file)  if (!is_dir($file)) {
	
	?>
	<div class="zips">
		 <a href="<?php echo htmlentities($file); ?>">
		 <?php $file = preg_replace("/\\.[^.\\s]{3,4}$/", "", $file);
		echo basename($file);?></a>
		
		<?php $t = basename($file);?>
		
		 <a class="del-backup" href="index.php?p=del-backup&f=<?php echo htmlentities($t);?>">x</a> 
		
	</div>
	<?php }
	} 
	$_SESSION["backups"] = $backups;
		
	?>

</div>

</div>