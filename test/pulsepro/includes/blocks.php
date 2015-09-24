<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<div id="sub-head">

<?php if($_GET["d"]){ 
		$folders = strtr($_GET["d"], "../","/");
		$folders = htmlspecialchars($folders, ENT_QUOTES, 'UTF-8');
	?>	<a href="index.php?p=blocks"><?php echo $lang_go_back; ?></a>
		<a href="index.php?p=new-block&d=<?php echo $folders; ?>"><?php echo $lang_blocks_newblock; ?></a>
		<a href="index.php?p=del-block&d=<?php echo $folders; ?>"><?php echo $lang_blocks_delfold; ?></a>
	<?php }else{ ?>
		<a href="index.php?p=new-block"><?php echo $lang_blocks_newblock; ?></a>
		<a href="index.php?p=new-folder"><?php echo $lang_blocks_newfold; ?></a>
	<?php } ?>  
	
</div>   

<div id="content">
<?php

function getFiles($folder="") {
	if($folder) {
		$files = glob("data/blocks/". $folder ."/*");
	}else {
		$files =  glob("data/blocks/*");
	}	

	foreach ($files as $file) { 
		if ($file != "." && $file != ".." ) {
			if($folder) {
				$dm[] = $file;;
			}else {
				$dm[] = $file;
			}	
			
		}
	}	
	return $dm;
}

if(!empty($_GET["d"] )) {
	$folders = strtr($_GET["d"], "../","/");
	$files = getFiles($folders);
}else {
	$files = getFiles();
}

if(count($files) >= 1){
	foreach ($files as $file) { 
		$nb++;
		if (!is_dir($file)) {
	?>

		<div class="icon">
		<?php if($folders){ ?>
			<a href="index.php?p=view&f=<?php echo $nb; ?>&d=<?php echo $folders; ?>">
		<?php }else{ ?>
			<a href="index.php?p=view&f=<?php echo $nb; ?>">
		<?php 
			}
			$info = preg_replace("/\\.[^.\\s]{3,4}$/", "", $file);
			echo basename($info);
			$blocks[$nb] = $file; 
			?>
		</a>
	</div>
	<?php 
		}else{
		$file_name =  basename($file);	
	?>	
		<div class="folder">
		<a href="index.php?p=blocks&d=<?php echo $file_name; ?>">
	
	<?php
	
		$blocks[$nb] = $file; 
		echo $file_name;
	?>
		</a>
		</div>
	<?php	
		}
	}
	$_SESSION["blocks"] = $blocks; 
}else{
	echo "<div class=\"left-pad\"><p>$lang_blocks_emptyfold</p></div>";
}	
?>
</div>