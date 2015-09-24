<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php 
error_reporting(0);
include('config.php'); 
include_once("path.php"); 
?>

<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $pulse_dir?>/plugins/flex/flexslider.css" />
<script src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $pulse_dir?>/plugins/jquery/jquery.min.js"></script>
<script src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $pulse_dir?>/plugins/flex/jquery.flexslider.js"></script>

<script type="text/javascript">
	$(window).load(function() {
	$('.flexslider').flexslider({
	slideshowSpeed: 6000,
	slideshow: true,
	keyboardNav: true,
	directionNav: false,
	controlNav: true,
	animationDuration: 600, 
	pauseOnAction: true,
	});
	});
</script>
	
<div class="flex-container">
<div class="flexslider">
<ul class="slides">

<?php 
if(!empty($_GET["g"])) 

$gallery = $_GET["g"];	

$opFile =  ROOTPATH . "/data/img/gallery/". $gallery ."/gallery.txt";
if($fp = fopen($opFile,"r")) {
    $data = @fread($fp, filesize($opFile));
    fclose($fp);

    $line = explode("\n", $data);
    $no_of_posts = count($line)-1;
           
    $lines = array_reverse($line);
           
    for ($i=0; $i<$no_of_posts; $i++) {
             
        $image = explode("|", $lines[$i+1]);
 
	    if($image[1] == $gallery) { 
	        
            echo "<li>\n";
            echo '<img  src="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. $image[2] .'" alt="'. $image[3] .'" />' . "\n";
            if(!empty($image[3])){
            echo '<p class="flex-caption">'. $image[3] .'</p>' . "\n";
            }
            echo "</li>\n\n";
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
        echo '<li><img src="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. basename($images[$i]) .'" alt="" /></li>';
        
        $new_data .= $i+1 ."|". $gallery ."|". basename($images[$i]) ."|\n"; 
    }
    
    $fp = @fopen($opFile,"w") or die($lang_blog_error_reading); 
    $success = fwrite($fp, $new_data);
    fclose($fp);
}


?>
</ul>
</div>
</div>