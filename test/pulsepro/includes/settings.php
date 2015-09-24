<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<form action="index.php?p=settings" method="post">
<div id="sub-head">
<button type="submit"><?php echo $lang_blog_button_update; ?></button>
</div>

<div id="content">
<?php
if($_POST["status"] == 1) {		

     if(isset($_SESSION["token"]) && isset($_SESSION["token_time"]) && isset($_POST["token"]) && $_SESSION["token"] == $_POST["token"]) {
        $timestamp_old = time() - (60*60);

        if($_SESSION["token_time"] >= $timestamp_old) {
	   
	        foreach($_POST as $var => $key) {
                $$var = htmlspecialchars(trim(stripslashes($key)), ENT_QUOTES, "UTF-8");
            }

	        $config = '<?php    
$pulse_dir = "'. $directory .'";
$pulse_pass = "'. $password .'";
$slider_style = '. $slider .';
$blog_url = "'. $blog_url .'";
$per_page = "'. $posts_per .'";
$blog_title = "'. $blog_title .'";
$rewrite = '. $rewrite .';
$blog_description = "'. $blog_description .'";
$blog_comments = '. $comments .';
$questions["'. $question1 .'"] = "'. $answer1 .'";
$questions["'. $question2 .'"] = "'. $answer2 .'";
$questions["'. $question3 .'"] = "'. $answer3 .'";
$date_format = "'. $date_format .'";
$settings_page = true;
$email_contact = "'. $email .'";
$pulse_lang = "'. $pulse_lang .'";
?>';


            if ($fp = fopen("includes/config.php", "w")) 
            {
                fwrite($fp, $config, strlen($config));
                
                echo "<p class=\"green\">$lang_setting_update</p>";
                echo "<p><a href=\"index.php?p=settings\" class=\"btn\">$lang_go_back</a></p>";
            }
            else 
            {
                echo "<p class=\"errorMsg\">$lang_settings_unwritable</p>"; 
            }

        }   
    
    }
}

if(empty($_SESSION["token"]) || $_SESSION["token_time"] <= $timestamp_old){
		 $_SESSION["token"] = md5(uniqid(rand(), TRUE));	
		 $_SESSION["token_time"] = time();
}

if(!isset($_POST["status"])) {
?>


    
    
    <table class="settings-table">

    <tr>
    <td colspan="2"><h2><?php echo $lang_setting_general; ?></h2></td>
    
    </tr>
    
    <tr>
    <th><?php echo $lang_setting_lang ?></th>
    <td><select name="pulse_lang">
		<option value="0" <?php echo ($pulse_lang) ? '' : 'selected="selected"';?>><?php echo $lang_setting_en ?></option>
		<option value="1" <?php echo ($pulse_lang) ? 'selected="selected"' : '';?>><?php echo $lang_setting_de ?></option>
		</select> 
    </td>
    </tr>
    
    <tr>
    <th><?php echo $lang_setting_folder ?></th>
    <td>
    <input class="med" type="text" name="directory" value="<?php echo $pulse_dir ?>"/>
    <p class="settings-hints"><?php echo $lang_setting_folder_hint ?></p>
    </td>
    </tr>

    <tr>
    <th><?php echo $lang_setting_password ?></th>
    <td><input class="med" type="text" name="password" value="<?php echo $pulse_pass ?>"/></td>
    </tr>
    
    <tr>
    <th><?php echo $lang_email_contact  ?></th>
    <td><input class="med" type="text" name="email" value="<?php echo $email_contact ?>"/></td>
    </tr>  
        
    <tr>
    <td colspan="2"><h2><?php echo $lang_setting_gallery; ?></h2></td>
    </tr>  

    <tr>
    <th><?php echo $lang_setting_gal_style ?></th>
    <td>
    
    <img src="img/thumbs-icon.png" alt="thumbs-icon" /> &nbsp;
    <input type="radio" name="slider" value="false" <?php if($slider_style == false) echo  'checked="checked"';?>/>&nbsp;
    <?php echo $lang_setting_gal_thumbs ?>&nbsp;
    <img src="img/slider-icon.png" alt="slider-icon" /> &nbsp;
    <input type="radio" name="slider" value="true" <?php if($slider_style == true) echo 'checked="checked"';?> />&nbsp;
    <?php echo $lang_setting_gal_slider ?> 
    </td>
    </tr>
    
    <tr>
    <td colspan="2"><h2><?php echo $lang_setting_blog; ?></h2></td>
    </tr>

    <tr>
    <th><?php echo $lang_setting_blog_title ?></th>
    <td><input class="long" type="text" name="blog_title" value="<?php echo $blog_title ?>" /></td>
    </tr>

    <tr>
    <th><?php echo $lang_setting_blog_desc ?></th>
    <td>
    <textarea class="long" rows="4" name="blog_description"><?php echo $blog_description ?></textarea>
    <p class="settings-hints"><?php echo $lang_setting_blog_desc_hint ?></p>
    </td>
    </tr>

    <tr>
    <th><?php echo $lang_setting_blog_url ?></th>
    <td>
    <input class="long "type="text" name="blog_url" value="<?php echo $blog_url ?>" />
    <p class="settings-hints"><?php echo $lang_setting_blog_url_hint ?></p>
    </td>
    </tr>

    <tr>
    <th><?php echo $lang_setting_blog_posts ?></th>
    <td><input class="small" type="text" name="posts_per" value="<?php echo empty($per_page)? 5 : $per_page; ?>" /></td>
    </tr>
    
    <tr>
    <th><?php echo $lang_setting_date ?></th>
    <td><select name="date_format">
		<option value="0" <?php echo ($date_format) ? '' : 'selected="selected"';?>>MM/DD/YYYY</option>
		<option value="1" <?php echo ($date_format) ? 'selected="selected"' : '';?>>DD/MM/YYYY</option>
		</select> 
    </td>
    </tr>

    <tr>
    <th><?php echo $lang_setting_blog_comments ?></th>
    <td><select name="comments">
    <option value="true" <?php echo ($blog_comments) ? 'selected="selected"' : '';?>><?php echo $lang_setting_blog_enabled ?></option>
    <option value="false" <?php echo ($blog_comments) ? '' : 'selected="selected"';?>><?php echo $lang_setting_blog_disabled ?></option>
    </select></td>
    </tr>
    
    <tr>
    <th><?php echo $lang_setting_blog_url_rewrite ?></th>
    <td>    
        <select name="rewrite" id="rewrite">
		    <option value="true" <?php echo ($rewrite) ? 'selected="selected"' : '';?>><?php echo $lang_setting_blog_enabled ?></option>
            <option value="false" <?php echo ($rewrite) ? '' : 'selected="selected"';?>><?php echo $lang_setting_blog_disabled ?></option>
		</select> 
	<p class="settings-hints"><?php echo $lang_setting_rewrite_hint ?></p>
    </td>
    </tr>

    <tr>
    <th valign="top"><?php echo $lang_setting_spam_questions ?></th>
    
    
    <td>
    <?php 
    $bn = 1;
    foreach($questions as $key => $val){ ?>
    <b><?php echo $lang_setting_spam_question ?> <?php $a = $bn++; echo $a?><br /><input class="long" type="text" name="question<?php echo $a?>" value="<?php echo $key?>" /></b><br />
    <br /><b><?php echo $lang_setting_spam_answer ?> <?php echo $a?><br /><input class="med" type="text" name="answer<?php echo $a?>" value="<?php echo $val?>" /></b><br /><br />
    <?php } ?>
    </td>
    </tr>

    </table>
    <input type="hidden" name="status" value="1" />
    <input type="hidden" name="token" value="<?php echo $_SESSION["token"] ?>" />
    </form>
<?php } ?>
</div>