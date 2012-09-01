<?php
	//CONFIGURATION
	

	//DEFINE Server Configuration

	//PATH to the root of the MIcons Builder
	$rootdir = 'http://tundem.phoenix.uberspace.de/penz/android/miconsProject/miconsBuilder/';
	//Name of the folder which contains the packed icons
	$workspace = 'workspace';
	//Name of the folder which contains the icons
	$iconsdir = '_icons';
	//Name of the folder which contains the alternatives
	$alternativesdir = '_alternatives';
	//Name of the folder which contains the assets to pack the theme
	$assetsdir = '_assets';
	//Name of the folder which contains the systemicons
	$systemiconsdir = '_systemicons';


	//DEFINE Theme configuration
	//This vars define some theme-specific values (you don't have to edit them) (perhaps the theme-prefix but yeah ;))
	$exportPrefix = 'micons_';
	$exportSuffix = '.mtz';
	$tempExportName = 'icons';


	//DEFINE misc stuff
	//This vars define a few seperators (you don't have to change them)
	$multiFileDivider = '|';
	$configDivider = '#';
	$singleConfigDivider = ';';


	//DEFINE all arrays
	//This vars define the alternatives and the resolutions including their names. I think these values should be self-explaining ;)
	$possibleResolutions = array('x90', 'x135');
	$possibleResolutionNames = array('hdpi', 'xhdpi'); //the specific string name for a specific resoltuion
	$possibleSystemstyles = array('alternative_folder', 'no_folder', 'original_folder'); //create a folder for each in your $systemiconsdir and put all sys-ressources in there
	$possibleSystemstyleNames = array('Original Folders', 'No Folder Background', 'Transparent Folder Background'); //These are the human-readable names for the systemstyles ;)


	//This array defines all available system icons.
	$folderFiles = array(
		'folder_icon_cover_01.png',
		'folder_icon_cover_02.png',
		'folder_icon_cover_03.png',
		'folder_icon_cover_04.png',
		'folder_icon_cover_05.png',
		'folder_icon_cover_06.png',
		'icon_background.png', 
		'icon_border.png', 
		'icon_folder.png',
		'icon_mask.png',
		'icon_pattern.png',
		'icon_shortcut_arrow.png',
		'icon_shortcut.png',
		'sym_def_app_icon.png'
		);

	//This array defines all available asset icons
	$assetFiles = array(
		$assetsdir.'/description.xml',
		$assetsdir.'/preview/preview_icons_0.png',
		$assetsdir.'/preview/preview_icons_1.png',
		$assetsdir.'/wallpaper/default_lock_wallpaper.jpg',
		$assetsdir.'/wallpaper/default_wallpaper.jpg'
		);


	//DEFINE descriptions
	//These vars can be cahnged and contain some text and theme-specific stuff ;)
	$headerText = 'MIcons <span>Project</span>';
	$subheaderText = 'a new iconset for your -MIUI-';
	$welcomeText = 'Welcome to the MIcons MIUI Theme Confogurator. With this small tool, you can choose all the icons you like. Different colors, different styles, different everything?<br><br>If you like the default style of an icon you do not have to choose an alternative, simply ignore the specific entry.<br>There are also more entries than your phone probably will need so you can ignore those too ;).<br><br>If you need help contact me @XDA.';
	$configDescriptionText = '[foldername];[appname];[imagename]|...  Copy and save it for later... You can paste it here again to get the same icons... (For now you can not change this configuration)';


	//DEFINE your social profiles ;)
	//Here you can set your social prfiles ;)
	$profilesActive = (int)2; //is needed to calculate the widht of the container
	$twitterProfile = 'mike_penz'; //only profile name
	$gplusProfile = '102816248419100947174'; //only profile ID
	$facebookProfile = ''; //Complete link
	$dribbbleProfile = ''; //Complete link
	$linkedinProfile = ''; //Complete link
	$forrstProfile = ''; //Complete link

?>