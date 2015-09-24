CKEDITOR.editorConfig = function( config )
{
config.toolbar = 'Full';

	config.scayt_autoStartup = false;
	config.filebrowserWindowWidth = '700';
    config.filebrowserWindowHeight = '500';
    config.enterMode = CKEDITOR.ENTER_P;
    config.shiftEnterMode = CKEDITOR.ENTER_BR;
    
    config.extraPlugins = 'more';
    
    config.height = 450;

    config.toolbar_Full =
    [
	['Save'],
    ['Bold','Italic'],
    ['NumberedList','BulletedList'],
    ['JustifyLeft','JustifyCenter','JustifyRight'],
    ['Link'],
    ['Image'],
    ['Format'],
    ['Table'],['Maximize'],['RemoveFormat'],['Source']
    ];

   config.filebrowserBrowseUrl = 'plugins/ckeditor/kcfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = 'plugins/ckeditor/kcfinder/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = 'plugins/ckeditor/kcfinder/browse.php?type=flash';
   config.filebrowserUploadUrl = 'plugins/ckeditor/kcfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = 'plugins/ckeditor/kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = 'plugins/ckeditor/kcfinder/upload.php?type=flash';
   // config.protectedSource.push( /<\?[\s\S]*?\?>/g );
};