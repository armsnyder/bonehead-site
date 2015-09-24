<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php 
error_reporting(0);
include('config.php'); 
include_once("path.php"); 
?>

<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $pulse_dir?>/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $pulse_dir?>/plugins/slimbox/js/slimbox2.js"></script>
<link rel="stylesheet" href="http://<?php echo $_SERVER['HTTP_HOST'] ?>/<?php echo $pulse_dir?>/plugins/slimbox/css/slimbox2.css" type="text/css" media="screen" />

<style type="text/css">
.gallery img {
margin: 7px;
padding:0;
width:90px;
height:90px;
float:left;
}

.gallery img:hover {
opacity: .6;
-webkit-transition: all .2s ease;
-moz-transition: all .2s ease;
-o-transition: all .2s ease;
transition: all .2s ease;
}

.gallery li {
padding:0;
margin:0;
list-style-type:none;
}

</style>

<div class="gallery">

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
	        echo '<a href="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. $image[2] .'" rel="lightbox-set" title="'. $image[3] .'" >' . "\n";
            echo '<img  src="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. $image[2] .'" alt="'. $image[3] .'" />';
            echo '</a>' . "\n\n";
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
        echo '<a href="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. basename($images[$i]) .'" rel="lightbox-set" >' . "\n";
        echo '<img src="http://'. $_SERVER['HTTP_HOST'] .'/'. $pulse_dir .'/data/img/gallery/'. $gallery .'/'. basename($images[$i]) .'" alt="" />';
        
        $new_data .= $i+1 ."|". $gallery ."|". basename($images[$i]) ."|\n"; 
    }
    
    $fp = @fopen($opFile,"w") or die($lang_blog_error_reading); 
    $success = fwrite($fp, $new_data);
    fclose($fp);
}


?>

</div>

<div style="clear:both"></div>