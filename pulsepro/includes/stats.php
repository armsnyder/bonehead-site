<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php $on = "stats";?>
<div id="sub-head">
<a href="#" onClick="window.location.href=window.location.href"><?php echo $lang_stats_refresh; ?></a>
</div>

<div id="content">

<?php
$today = date("m.d.y");
$adr="data/stats/$today.txt";

//reading data
$contents=file($adr);
$contents=array_reverse($contents);
$data=array();
foreach ($contents as $line) 	
if(trim($line)!="")
	$data[]=explode("|",$line);

$views=count($contents);

//calculating stats
$visitors=array();
$referers=array();
$pages=array();
$day_list=array();
	
foreach ($data as $visit)
{
	if(count($day_list) <10)
	{
		
		$day=trim($visit[3]);
		$month=trim($visit[4]);
		$year=trim($visit[5]);
		$ip=trim($visit[0]);
		$page=trim($visit[1]);
		$referer=trim($visit[2]);

		//referers 
		$referer_host=parse_url($referer,PHP_URL_HOST);
		if ($referer_host!= "" && $referer_host!= false )
			if(stripos (parse_url($referer,PHP_URL_HOST) , $_SERVER["HTTP_HOST"]) === false  
					&& stripos ($_SERVER["HTTP_HOST"] , parse_url($referer,PHP_URL_HOST))=== false   )
			{
				if(!isset($referers[$referer]))
				{
					$referers[$referer]=1;
				}
				else $referers[$referer]++;
			}
		
		//top pages 
		if(!isset($pages[$page]))
			$pages[$page]=1;
		else
			$pages[$page]++;
			
				
		//visitors
		if(!isset($visitors[$year][$month][$day][$ip]))
		{
			$visitors[$year][$month][$day][$ip]=1;
			if( ! in_array(array($year,$month,$day),$day_list  ))  $day_list[]=array($year,$month,$day);
		}
		else 
			$visitors[$year][$month][$day][$ip]++;
	}
	
	else break;
}

// Number of visitors
$counter=isset($visitors[date('y')][date('m')][date('d')])?count($visitors[date('y')][date('m')][date('d')]) :"0";
echo '<div class="black">';
echo "<p class=\"num\">$counter</p>";
echo "<p class=\"desc\">$lang_stats_today</p></div>";

//Number of page views
echo '<div class="black">';
echo "<p class=\"num\">$views</p>";
echo "<p class=\"desc\">$lang_stats_pageviews</p></div>";

echo '<div class="clear"></div>';

//Top 20 pages 
echo '<div class="pages">';
echo "<h2>$lang_stats_pages</h2>";
asort($pages);
$pages=array_reverse($pages, true);
$nb_pages=10;

foreach ($pages as $key => $value)
{
	if ($nb_pages>0  )
	
	{
		if ($key!="")
		{	
			echo $value . " &nbsp; " . "<a target=\"_blank\" class=\"refer\" href='".$key."'>" . substr($key, 0,45) . "</a><br>\n";
			$nb_pages--;
		}
	}
	else break;
}
echo '</div>';

// Top 20 referers
echo '<div class="refers">';
echo "<h2>$lang_stats_refers</h2>";
asort($referers);
$referers=array_reverse($referers, true);
$nb_referers=10;

foreach ($referers as $key => $value)
{
	if ($nb_referers>0  )
	
	{
		if ($key!=""){
		
			if (!(preg_match("/google/i",$key)) and !(preg_match("/localhost/i",$key))and !(preg_match("/yahoo/i",$key))  and !(preg_match("/bing/i",$key)) and !(preg_match("/yandex/i",$key))){
			
			$key= str_replace("http://","", $key);
			$key= str_replace("www.","", $key);
			
			
			echo $value . " &nbsp; " . "<a target=\"_blank\" class=\"refer\" href='http://".$key."'>" . substr($key, 0,45) . "</a><br>\n";
			$nb_referers--;
		}
	}
	
}	
	else break;
	
}

echo '</div>';

?>

<div class="clear"></div>

<div class="howto">
	<a href="javascript:doMenu('main');" id=xmain><?php echo $lang_embed; ?></a>
	<div id="main" style="display:none;">
	<p><?php echo $lang_stats_embed; ?></p>
	<input value='&lt;?php include_once("<?php echo ROOTPATH ?>/includes/tracker.php"); ?&gt;' onclick="select_all(this)" >
	</div>
</div>

</div>