<?php

include_once("config.php"); 
include_once("path.php");
define("_MAX_TRACK_DAYS_","2");

if($_SERVER['HTTP_USER_AGENT'] != 'FeedBurner/1.0 (http://www.FeedBurner.com)' &&
   $_SERVER['HTTP_USER_AGENT'] != '' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Web-sniffer/1.0.36 (+http://web-sniffer.net/)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Googlebot/2.1 (+http://www.googlebot.com/bot.html)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Googlebot/2.1 (+http://www.google.com/bot.html)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'DoCoMo/2.0 N905i(c100;TB;W24H16) (compatible; Googlebot-Mobile/2.1; +http://www.google.com/bot.html' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'ia_archiver (+http://www.alexa.com/site/help/webmasters; crawler@alexa.com)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; MJ12bot/v1.4.0; http://www.majestic12.co.uk/bot.php?+)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Java/1.6.0_13' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Java/1.6.0_24' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Wget/1.11.4 Red Hat modified' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; aiHitBot/1.0; +http://www.aihit.com/)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'msnbot/2.0b (+http://search.msn.com/msnbot.htm)._' &&
   $_SERVER['HTTP_USER_AGENT'] != 'JS-Kit URL Resolver, http://js-kit.com/' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; TweetmemeBot/2.11; +http://tweetmeme.com/)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/4.0 (compatible; MSIE 7.0; Windows; Windows NT 5.1) BrokenLinkCheck.com/1.1' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.8.1) VoilaBot BETA 1.2 (support.voilabot@orange-ftgroup.com)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'spider' &&
   $_SERVER['HTTP_USER_AGENT'] != 'SeznamBot/3.0 (+http://fulltext.sblog.cz/)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'rganalytics' &&
   $_SERVER['HTTP_USER_AGENT'] != 'UnisterBot (Mozilla/5.0 compatible; crawler@unister-gmbh.de)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'scour/1.0' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Java/1.6.0_26' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) Speedy Spider (http://www.entireweb.com/about/search_tech/speedy_spider/)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Yeti/1.0 (NHN Corp.; http://help.naver.com/robots/)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Mozilla/5.0 (compatible; Ezooms/1.0; ezooms.bot@gmail.com)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'W3C_Validator/1.2' &&
   $_SERVER['HTTP_USER_AGENT'] != 'Who.is Bot' &&
   $_SERVER['HTTP_USER_AGENT'] != 'msnbot-media/1.1 (+http://search.msn.com/msnbot.htm)' &&
   $_SERVER['HTTP_USER_AGENT'] != 'http://SiteIntel.net Bot' &&
   $_SERVER['HTTP_USER_AGENT'] != 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)')
{
$all = $_SERVER['REMOTE_ADDR']."|".$_SERVER['REQUEST_URI']."|".(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"") ."|".date('d')."|".date('m')."|".date('y')."\n";

$today = date("m.d.y");
define("_TRACK_FILE_", ROOTPATH . "/data/stats/$today.txt");

$name = glob(ROOTPATH . "/data/stats/*.txt");

foreach($name as $fl){
	$file= basename($fl,".txt");	

if((ROOTPATH . "/data/stats/$today.txt") != (ROOTPATH . "/data/stats/$file.txt")){

unlink(ROOTPATH . "/data/stats/$file.txt");
}}
	
$file_han=fopen(_TRACK_FILE_,"a");

if (flock($file_han, LOCK_EX)) {    
fwrite($file_han,$all);

flock($file_han, LOCK_UN); 
}
fclose($file_han);
}

?>