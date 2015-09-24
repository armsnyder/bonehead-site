<?php 
session_cache_expire(180);
error_reporting(0);
include_once("includes/config.php");
include_once("includes/path.php");

if($pulse_lang == 0){
include_once("includes/lang.php");}
else
if($pulse_lang == 1){
include_once("includes/lang_de.php");}

include_once("includes/login.php");
include_once("includes/nav-controller.php");
include_once("includes/header.php");
include_once("includes/controller.php");
include_once("includes/footer.php"); 
?>