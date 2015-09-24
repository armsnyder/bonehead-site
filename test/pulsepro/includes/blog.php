<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<?php
error_reporting(0);
include_once("config.php"); 
include_once("path.php");

if($pulse_lang == 0){
include_once("lang.php");}
else
if($pulse_lang == 1){
include_once("lang_de.php");}

$x="0";

$domain = $_SERVER['HTTP_HOST'];

if(empty($_POST["question"])){
	$question = array_rand($questions, 1);
	$answer = strtolower($questions[$question]);
} 
?>
<link rel="alternate" title="Blog" href="http://<?php echo $domain?>/<?php echo $pulse_dir?>/rss.php" type="application/rss+xml" >

<link href="http://<?php echo $domain ?>/<?php echo $pulse_dir ?>/css/blog.css" rel="stylesheet" type="text/css" >

<div class="blog-wrap">

<?php

$opFile =  ROOTPATH . "/data/blog/blogfile.txt";

$fp = fopen($opFile, "r") or die("Error Reading File");
$data = @fread($fp, filesize($opFile));
fclose($fp);

if(!empty($_GET["d"]) && is_numeric($_GET["d"])) {
$id_post = $_GET["d"];

$filename = ROOTPATH . "/data/blog/comments.txt";


if(!empty($_POST["answers"]) 
   &&  $questions[stripslashes($_POST["question"])] == strtolower(trim($_POST["answers"])) 
   &&  md5($questions[stripslashes($_POST["question"])]) ==  $_POST["token"]) {
	$resp = 1;
} elseif (isset($_POST["answers"])) {
	$resp = 2;
	$question = array_rand($questions, 1);	
	$answer = strtolower($questions[$question]);	
	
}	

if(!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['comment']) &&  $blog_comments) {
	
		//Post a comments  	
		$email = strip_tags(htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8'));
		
		$name = strip_tags(trim(stripslashes($_POST['name'])));        
        
		$comment = strip_tags(stripslashes($_POST['comment']),'<p><br><a>');
		
	if(preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST['mail'])) {

		if($resp == 1) {
			$x="1";
			$comment = str_replace("\n", "<br />", $comment);
			$comment = str_replace("\r", "", $comment);
			$comment = str_replace("|", "&brvbar;", $comment);
			$postdate = date('D, d M Y H:i:s O');
			$blog = $id_post."|".$postdate."|".$name."|".$email."|".$comment."\n";
			
			$fp = fopen($filename, "a");
			fwrite($fp, $blog);
			fclose($fp);
	
			//update Number of comments  	
			$fp = fopen($opFile,"r") or die("Error Reading File");
			$data = @fread($fp, filesize($opFile));
			fclose($fp);

		    $line = explode("\n", $data);

			$nb = count($line);
			for($i=0; $i < $nb; $i++) { 
				$blog = explode("|", $line[$i]);
			
				if($blog[0] == $id_post) {			  
				   	 $blog[1]++;
				   	 $new_data .=  $blog[0]. "|" . $blog[1] ."|".$blog[2]."|".$blog[3]."|".$blog[4]."\n";
				   	
				} elseif($blog[0] != "") {
					 $new_data .=  $blog[0]. "|" . $blog[1] ."|".$blog[2]."|".$blog[3]."|".$blog[4]."\n";
				}
			}
		
			$file = fopen($opFile,"w") or die("Error Reading File"); 
			$success = fwrite($file, $new_data);
			fclose($file); 
			
			unset($email);
			unset($name);
			unset($comment);
			$question = array_rand($questions, 1);	
			$answer = strtolower($questions[$question]);
		}

	} else {
		$error = 1;
		$question = array_rand($questions, 1);	
		$answer = strtolower($questions[$question]);
    }
		
} else {

	$error = 1;
	$question = array_rand($questions, 1);	
	$answer = strtolower($questions[$question]);	
}

// show articles
$line = explode("\n", $data);

$nb = count($line);

for($i=0; $i < $nb; $i++) { 
	$blog = explode("|", $line[$i]);
	if($blog[0] == $id_post) {
	   $date = explode( ' ' , $blog[2]);
		$date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];
	    echo "<h2 class=\"blog-title\">" .$blog[3]."</h2>\n";
	    if($date_format) {
	    	echo "<div class=\"blog-date\">" . date("d-m-Y", strtotime($date))."</div>\n";
	    } else {
	    	echo "<div class=\"blog-date\">" . date("m-d-Y", strtotime($date))."</div>\n";
	    }
		echo "<div class=\"blog-content\">" . str_replace("##more##", "", $blog[4]) ."</div>\n\n";
		break;
	}
}

include("clean_url.php");

echo "<script type=\"text/javascript\">document.title = \"$blog[3]\";</script>\n\n";

if($x==="1"){
$sender_Name = "PulseCMS"; 
$sender_email = $email_contact;
$recipient = $email_contact;
$mail_body = $lang_blog_notify . $blog[3];
$subject = $lang_blog_subject;
$header = "From: ". $sender_Name . " <" . $sender_email . ">\r\n";
mail($recipient, $subject, $mail_body, $header); 
}

?>

<div class="share-buttons">

<div style='float:left;padding-right:15px'>
<div class="g-plusone" data-size="medium" data-annotation="none"></div>
</div>

<div style='float:left;padding-right:15px'>
<a align="bottom" href="https://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
</div>

<div style='float:left;'>
<fb:like colorscheme='light' expr:href='data:post.url' font='' layout='button_count' send='false' show_faces='false'/>
</div>

</div>

<?php

// show comments

echo "<div class=\"comments\">";

if( $blog_comments) {

$fp = fopen($filename, "r") or die("$lang_blog_error_reading");
$data = @fread($fp, filesize($filename));
fclose($fp);

$line = explode("\n", $data);

$nb = count($line);
for($i=0; $i < $nb; $i++) { 
	$blog = explode("|", $line[$i]);
	if($blog[0] == $id_post) {
	   
	   $date = explode( ' ' , $blog[1]);
	   $date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];
	    
	    echo "<div class=\"comment-line\">\n";
	    if($date_format) {
	    	echo "<div class=\"comment-date\">". date("d-m-Y", strtotime($date))."</div>\n";
	    } else {
	    	echo "<div class=\"comment-date\">". date("m-d-Y", strtotime($date))."</div>\n";
	    } 
	    
	    
	    echo "<div class=\"comment-name\">". $blog[2]."</div>\n";
		echo "</div>\n";
		echo "<div class=\"blog-comment\">" .$blog[4]."</div>\n\n";
	
	}
}
?>
	<form class="comment-form" action="<?php if($rewrite) {echo "blog-$id_post-$clean_url";} else {echo "?d=$id_post";}?>" method="post">
		<?php
			 if($error == 1 && isset($_POST['name']) && isset($_POST['mail'])) echo "<span style=\"color:red\">$lang_blog_error_check</span><br />";	
			 
			 if ($resp == 2) {
				  echo "<span style=\"color:red\">$lang_blog_error_captcha</span>";
			  } 
			?>

		<p class="add"><b><?php echo $lang_blog_add_comment; ?></b></p>
		<p><label class="comment-label"><?php echo $lang_blog_label_name; ?></label><br /><input type="text" name="name" size="45" value="<?php echo $name ?>" /></p>
		<p><label class="comment-label"><?php echo $lang_blog_label_email; ?></label><br /><input size="45" type="text" name="mail" value="<?php echo $email ?>" /></p>
		<p><label class="comment-label"><?php echo $lang_blog_label_comment; ?></label><br />
		<textarea name="comment" cols="60" rows="7"><?php echo $comment ?></textarea>
		</p>
		<p><label class="comment-label"><?php echo $question; ?> </label> <input type="hidden" name="token" value="<?php echo md5($answer); ?>" /><input type="hidden" name="question" value="<?php echo $question; ?>" /> <input type="text" name="answers" /></p>

		<p><button type="submit"><?php echo $lang_blog_submit; ?></button></p>
		
	</form>

<?php	
}
} else {
	$line = explode("\n", $data);
	$records = count($line)-1;
	$result_per_page = $per_page ; 
	$total_pages = ceil($records/$result_per_page);

	$cur_page = $_GET[page] ? $_GET[page] : 1;

	$start = $records - (($cur_page-1) * $result_per_page);
	$end = $records - (($cur_page) * $result_per_page);

	for ($n=$start-1  ;  $n>=$end  ;  $n-- ) { 
		$blog = explode("|", $line[$n]);
		
		if (isset($blog[0]) & $blog[0] != '') {
			
			$date = explode( ' ' , $blog[2]);
			$date = $date[2] . ' ' . $date[1]  . ' ' . $date[3];
			
			include("clean_url.php");
			
			if($rewrite) {
			    echo "<h2 class=\"blog-title\"><a href=\"blog-". $blog[0] ."-$clean_url\">" .$blog[3]."</a></h2>\n";
			} else {
		        echo "<h2 class=\"blog-title\"><a href=\"?d=". $blog[0] ."\">" .$blog[3]."</a></h2>\n";
			}
			
			if($date_format) {
				echo "<div class=\"blog-date\">" . date("d-m-Y", strtotime($date))."</div>\n";
			} else {
				echo "<div class=\"blog-date\">" . date("m-d-Y", strtotime($date))."</div>\n";
			} 
			
			if( $blog_comments) {
				
				if(preg_match("/^(.*)##more##/U", $blog[4], $m)) {
				     
				    if($rewrite) {
			             echo "<div class=\"blog-content\">" . $m[1] ." <a href=\"blog-". $blog[0] ."-$clean_url\" class=\"read-more\">$lang_blog_more</a></div>\n";
			        } else {
		                 echo "<div class=\"blog-content\">" . $m[1] ." <a href=\"?d=". $blog[0] ."\" class=\"read-more\">$lang_blog_more</a></div>\n";
			        }
				     
				} else {
				     echo "<div class=\"blog-content\">" . $blog[4] ."</div>\n";
				}
				
				if($blog[1]) {
				    
				    if($rewrite) {
			            echo  "<div class=\"num_comments\"><a href=\"blog-". $blog[0] ."-$clean_url\">(". $blog[1] .") $lang_blog_num_comment</a></div>\n\n";
			        } else {
		                echo  "<div class=\"num_comments\"><a href=\"?d=". $blog[0] ."\">(". $blog[1] .") $lang_blog_num_comment</a></div>\n\n";
			        }	
					
				} else {
					if($rewrite) {
			            echo "<div class=\"num_comments\"><a href=\"blog-". $blog[0] ."-$clean_url\">$lang_blog_no_comment</a></div>\n\n";
			        } else {
		                echo "<div class=\"num_comments\"><a href=\"?d=". $blog[0] ."\">$lang_blog_no_comment</a></div>\n\n";
			        }	

				}
			
			} else {
				if(preg_match("/^(.*)##more##/U", $blog[4], $m)) {
				     if($rewrite) {
			            echo "<div class=\"blog-content\">" . $m[1] ." <a href=\"blog-". $blog[0] ."-$clean_url\" class=\"read-more\">$lang_blog_more</a></div>\n";
			         } else {
		                 echo "<div class=\"blog-content\">" . $m[1] ." <a href=\"?d=". $blog[0] ."\" class=\"read-more\">$lang_blog_more</a></div>\n";
			         }	
				     
				} else {
				     echo "<div class=\"blog-content\">" . $blog[4] ."</div>\n";
				}
			}
		}
		else {
			continue;
		}
	}

	echo '<div class="blog-pagination">';

		if ($cur_page<$total_pages) {

		if($rewrite) {
            echo "<a href=\"". $prefix ."blog-page-" . ($cur_page+1) . "\">" . $lang_blog_older . "</a>" . "&nbsp;&nbsp;&nbsp;";
        } else {
            echo "<a href=\"?page=" . ($cur_page+1) . "\">" . $lang_blog_older . "</a>" . "&nbsp;&nbsp;&nbsp;";
        }	
					
	}

	if ($cur_page>1) {		
		
		if($rewrite) {
            echo  "<a href=\"". $prefix ."blog-page-" . ($cur_page-1) . "\">" . $lang_blog_newer . "</a>";
        } else {
            echo "<a href=\"?page=" . ($cur_page-1) . "\">" . $lang_blog_newer . "</a>" . "&nbsp;&nbsp;&nbsp;";
        }	
		
	}
}

echo '</div></div>';
?>
