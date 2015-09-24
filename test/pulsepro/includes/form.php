<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php

// Custom Fields, enter a name in between quotes to activate

$custom_fieldname1 = ""; // Custom Field 1
$custom_fieldname2 = ""; // Custom Field 2

error_reporting(0);
include_once("config.php");
include_once("lang.php");
$domain = $_SERVER['HTTP_HOST'];

if($pulse_lang == 0){
include_once("lang.php");}
else
if($pulse_lang == 1){
include_once("lang_de.php");}

if (preg_match("/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $_POST['email'])){
     $name = strip_tags($_POST['name']);
     $email = $_POST['email'];
     $custom_message1 = strip_tags ($_POST['custom1']);
     $custom_message2 = strip_tags ($_POST['custom2']);
          
     if(isset($_POST['custom1']) && (isset($_POST['custom2']))){
     $comment = "$custom_fieldname1: ". $custom_message1 ."\n"."\n"."$custom_fieldname2: ". $custom_message2 ."\n". "\n". (stripslashes(strip_tags($_POST['comment'])));}
     
     elseif(isset($_POST['custom1'])){
     $comment = "$custom_fieldname1: ". $custom_message1 ."\n"."\n". (stripslashes(strip_tags($_POST['comment'])));}
         
     elseif(isset($_POST['custom2'])){
     $comment = "$custom_fieldname2: ". $custom_message2 ."\n"."\n". (stripslashes(strip_tags($_POST['comment'])));}
     
     else{$comment = stripslashes(strip_tags($_POST['comment']));}
          
     $headers  = "From: '". $name ."' <". $email .">\n";
     $headers .= "Reply-To: '". $name ."' <". $email .">\n";
     $headers .= "Content-Type: text/plain; charset=\"utf-8\"\n";
     $headers .= "Content-Transfer-Encoding: 8bit\n";
     $headers .= "MIME-Version: 1.0\n";

     if($name && $comment && empty($_POST['human'])){
         if(mail($email_contact, "$lang_form_subject", $comment, $headers)){
              echo "<p class=\"msg-green\">$lang_form_message_sent</p>";
         }else{
              echo "<p class=\"msg-red\">$lang_form_not_sent</p>";
         }
     }else{
            echo "<p class=\"msg-red\">$lang_form_all_fields</p>";
     } 
                
	}elseif(isset($_POST['email'])){     
    
    echo "<p class=\"msg-red\">$lang_form_valid_email</p>";        
}
?>
<link rel="stylesheet" href="http://<?php echo $domain ?>/<?php echo $pulse_dir ?>/css/form.css" media="all">

<form id=contact method=post>

<fieldset>
<label for="name"><?php echo $lang_form_label_name; ?></label><br>
<input id="name" name="name" type="text">
</fieldset>

<fieldset>
<label for="email"><?php echo $lang_form_label_email; ?></label><br>
<input id="email" name="email" type="email">
</fieldset>

<!-- Custom Field 1 -->
<?php  if(!empty($custom_fieldname1)) {?>
<fieldset>
<label for="custom1"><?php echo "$custom_fieldname1"; ?></label><br>
<input id="custom1" name="custom1" type="text">
</fieldset>
<?php } ?>

<!-- Custom Field 2 -->
<?php  if(!empty($custom_fieldname2)) {?>
<fieldset>
<label for="custom2"><?php echo "$custom_fieldname2"; ?></label><br>
<input id="custom2" name="custom2" type="text">
</fieldset>
<?php } ?>

<fieldset>
<input id="human" name="human" type="text">  
<label for="comment"><?php echo $lang_form_label_comment; ?></label><br>
<textarea id="comment" name="comment" rows="8"></textarea>
</fieldset>

<button type="submit"><?php echo $lang_form_send; ?></button>

</form>