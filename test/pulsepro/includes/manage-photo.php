<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<div id="sub-head">

<a href="index.php?p=choose-img&g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>" class="top-btn"><?php echo $lang_gal_upload; ?></a>
	&nbsp;
	<a href="index.php?p=del-gal&g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>" class="top-btn"><?php echo $lang_gal_del_gallery; ?></a> 
	&nbsp;
	<a target="_blank" href="includes/gallery-preview.php?g=<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>" class="top-btn"><?php echo $lang_gal_preview; ?> &rarr;</a>    

</div>

<div id="content">
<?php 

if(!empty($_GET["g"])) {
    $gallery = str_replace("..", "",  $_GET["g"]);
    
    $opFile =  ROOTPATH . "/data/img/gallery/". $gallery ."/gallery.txt";
    
    if($fp = fopen($opFile,"r")) {
        $data = @fread($fp, filesize($opFile));
        fclose($fp);

        $line = explode("\n", $data);
        $nb = count($line)-1;
        
        $lines = array_reverse($line);
               
        for ($i=0; $i<$nb; $i++) {
            
            $image = explode("|", $lines[$i+1]);
            
	        if($image[1] == $gallery) { 
	            echo '<div class="thumb">';
                echo '<a href="index.php?p=captions&f='. $image[0] .'&g='. $image[1] .'">';
                echo '<img src="data/img/gallery/'. $gallery .'/'. $image[2] .'" alt="'. $image[3] .'"  class="thumb-pic"/>';
                echo '</a>';
                echo '<a href="index.php?p=captions&f='. $image[0] .'&g='. $image[1] .'">';
                echo '<img src="img/pencil-icon.png" class="mag-glass" />';
                echo '</a>';
                echo "<a href=\"index.php?p=del-img&f=". $image[0] ."&g=". $gallery ."\" class=\"del-img\">$lang_gal_delete</a>";
                echo "</div>"; 
	        }
        }
    } else {
        $directory = ROOTPATH . "/data/img/gallery/$gallery/"; 

        $images = array();
        if($image1 = glob($directory."/*.jpg")) $images = $image1;
        if($image2 = glob($directory."/*.jpeg")) $images = array_merge($images,$image2);
        if($image3 = glob($directory."/*.JPG")) $images = array_merge($images,$image3);
        if($image4 = glob($directory."/*.JPEG")) $images = array_merge($images,$image4);
        if($image5 = glob($directory."/*.gif")) $images = array_merge($images,$image5);

        array_multisort(array_map('filemtime', $images), SORT_DESC, $images);  

        $nb = count($images); 
        for($i=0; $i<$nb; $i++) {
            echo '<div class="thumb">';
            echo '<a href="index.php?p=captions&f='. ($i+1) .'&g='. $gallery .'">';
            echo '<img src="data/img/gallery/'. $gallery .'/'. basename($images[$i]) .'" alt=""  class="thumb-pic"/>';
            echo '</a>';
            echo '<a href="data/img/gallery/'. $gallery .'/'. basename($images[$i]) .'" id="lightbox" rel="lightbox-set" >';
            echo '<img src="img/mag-glass.png" class="mag-glass" />';
            echo '</a>';
            echo "<br><a href=\"index.php?p=del-img&f=". ($i+1) ."&g=". $gallery ."\" class=\"del-img\">$lang_gal_delete</a>";
            echo "</div>"; 
            $new_data .= $i+1 ."|". $gallery ."|". basename($images[$i]) ."|\n"; 
        }
        
        $fp = @fopen($opFile,"w") or die($lang_blog_error_reading); 
        $success = fwrite($fp, $new_data);
        fclose($fp);
    }
     
    if($nb <= 0) {
        echo "<p class=\"created\">". $lang_gal_empty ."</p><br><br>";
    }
}
?>	

<div class="clear"></div>
	 	
<div class="howto">
	<a href="javascript:doMenu('main');" id=xmain><?php echo $lang_embed; ?></a>
	<div id="main" style="display:none;">
	<p><?php echo $lang_embed_desc; ?></p>
	<input value='&lt;?php $gallery ="<?php if(!empty($_GET["g"])) echo htmlentities($_GET["g"]); ?>";  $max_img = "50"; include("<?php echo $pulse_dir; ?>/includes/<?php if($slider_style) {echo 'gallery.php';} else { echo 'gallery2.php'; } ?>"); ?&gt;' onClick="select_all(this)" >             
	<br><?php echo $lang_embed_desc2; ?>
	</div>
</div>

</div>