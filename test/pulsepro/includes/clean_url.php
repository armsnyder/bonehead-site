<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php
$clean_url = $blog[3];
$clean_url = strtolower($clean_url);
$clean_url = str_replace('-', '', $clean_url);
$clean_url = str_replace(' ', '-', $clean_url);
$clean_url = str_replace(',', '', $clean_url);
$clean_url = str_replace('&', '', $clean_url);
$clean_url = str_replace('!', '', $clean_url);
$clean_url = str_replace(')', '', $clean_url);	
$clean_url = str_replace('(', '', $clean_url);
$clean_url = str_replace('.', '', $clean_url);	
$clean_url = str_replace(':', '', $clean_url);
$clean_url = str_replace('#039;', '', $clean_url);
$clean_url = str_replace('/', '', $clean_url);
$clean_url = str_replace('&', '', $clean_url);
$clean_url = str_replace('amp;', '', $clean_url);
$clean_url = str_replace('--', '-', $clean_url);
?>