<?php /* Copyright PulseCMS.com. All rights reserved. */ ?>
<?php
$page = $_REQUEST['p'];

switch ($page) {
	
	default:
	case "blocks":
	case "view":
	case "new-block":
	$on = "blocks";
	break;
	
	case "manage-gallery":
	case "choose-img":
	case "upload-img":
	case "manage-photo":
	case "new-gallery":
	case "del-img":
	case "del-gal":
	case "captions":
	$on = "images";
	break;	
			
	case "manage-blog":
	case "edit-post":
	case "post":
	case "del-post":
	case "update-post":
	case "process":
	$on = "blog";
	break;
		
	case "list-backups":
	case "backup":
	case "del-backup":
	$on = "backup";
	break;
		
	case "settings":
	$on = "settings";
	break;
		
	case "manage-form":
	$on = "form";
	break;
	
	case "stats":
	$on = "stats";
	break;
	
	case "boneheads":
	$on = "boneheads";
	break;
	
	case "database":
	$on = "database";
}
?>
