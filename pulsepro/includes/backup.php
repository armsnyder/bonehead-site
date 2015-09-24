<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<div id="sub-head">

<a href="index.php?p=list-backups"><?php echo $lang_go_back; ?></a>

</div>

<div id="content">

<?php

$today = date("m.j.y-gi");

function Zip($sources, $destination)
{
    if (extension_loaded('zip') === true)
    {
	
			$zip = new ZipArchive();

			if ($zip->open($destination, ZIPARCHIVE::CREATE) === true)
			{
				foreach ($sources as $source)
				{
					if (file_exists($source) === true)
					{
						$source = realpath($source);

						if (is_dir($source) === true)
						{
								$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
								
								foreach ($files as $file)
								{
										$file = realpath($file);

										if (is_dir($file) === true)
										{
												
												$zip->addEmptyDir(basename($source).DIRECTORY_SEPARATOR.str_replace($source . DIRECTORY_SEPARATOR, '', $file ));
										}

										else if (is_file($file) === true)
										{
												$zip->addFromString(basename($source).DIRECTORY_SEPARATOR. str_replace($source . DIRECTORY_SEPARATOR, '', $file), file_get_contents($file));
										}
								}
						}

						else if (is_file($source) === true)
						{
								$zip->addFromString(basename($source), file_get_contents($source));
						}
					}
				}
			}
			else echo "error creating destination";

			return $zip->close();
	
    }
	else echo "zip extention not loaded" ;

    return false;
}

Zip(array('./data/blocks','./data/blog','./data/img','./data/stats') , "./data/backups/" . $today . ".zip");


print "<p class=\"green\"><b>$lang_backup_complete</b></p>";

?>

<?php $_SESSION["backups"] = $backups; ?>

</div>