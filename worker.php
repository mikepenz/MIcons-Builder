<?php
	require_once('config.php');

	function create_icons_zip($workspace = 'workspace', $iconsdir = '_icons', $resolution = 'x135', $resolutionname = 'xhdpi', $sessionId = '', $outputfile = 'icons.zip') {
		$files = file_list($iconsdir."/".$resolution, "");

		foreach ($files as $arrKey => $arrVal) {
			$files[$arrKey] = $iconsdir.'/'.$resolution.'/'.$arrVal;
	    }

		//foreach ($files as $arrKey => $arrVal) {
		//	echo $arrKey . " - " . $arrVal . "<br>";
	    //}

	    if(!file_exists($workspace.'/'.$sessionId)) {
	    	mkdir($workspace.'/'.$sessionId);
	    }
		return create_zip($files, $workspace.'/'.$sessionId.'/'.$outputfile, false, array($iconsdir.'/'.$resolution.'/'), '');	
	}

	function add_system_icons_to_zip($workspace, $systemiconsdir, $sessionId, $resolution = 'x135', $resolutionname = 'xhdpi', $systemiconstyle, $icons) {
		$systemfiles = file_list($systemiconsdir.'/'.$systemiconstyle.'/'.$resolution, "");


		foreach ($systemfiles as $arrKey => $arrVal) {
			$systemfiles[$arrKey] = $systemiconsdir.'/'.$systemiconstyle.'/'.$resolution.'/'.$arrVal;
	    }

		//foreach ($systemfiles as $arrKey => $arrVal) {
		//	echo $arrKey . " - " . $arrVal . "<br>";
	    //}

	    add_files2zip($systemfiles, $icons, array($systemiconsdir.'/'.$systemiconstyle.'/'.$resolution.'/', ), '');
	    return add_files2zip($systemfiles, $icons, array($systemiconsdir.'/'.$systemiconstyle.'/'.$resolution.'/', ), 'res/'.$resolutionname.'/');
	}

	function add_configurated_icons_to_zip($workspace, $alternativesdir = '_alternatives', $configuration, $sessionId, $resolution = 'x135', $icons, $configDivider, $singleConfigDivider) {
		$configuratedIconPairs = explode($configDivider, $configuration);

		$fileArray = array();
		$nameArray = array();

		$count = (int)0;
		foreach ($configuratedIconPairs as $pair) {
			$keyValue = explode($singleConfigDivider, $pair);

			if (!isset($keyValue[0]) || !isset($keyValue[1]) || !isset($keyValue[2])) {
				break;
			}

			$folderName = $keyValue[0];
			$appName = $keyValue[1];
			$iconFile = $keyValue[2];

			if($folderName == '' || $appName == '' || $iconFile == '') {
				break;
			}

			$fileArray[$count] = $alternativesdir.'/'.$resolution.'/'.$folderName.'/'.$iconFile;
			$nameArray[$count] = $appName.'.'.substr($iconFile, -3);

			$count ++;
		}
		
		return add_files2zipWithName($fileArray, $nameArray, $icons);
	}


	function create_theme_mtz($workspace, $assetsdir, $sessionId, $assets, $icons, $outputfile = 'micons.mtz') {
		$assets[count($assets)] = $icons;

		//foreach ($assets as $arrKey => $arrVal) {
		//	echo $arrKey . " - " . $arrVal . "<br>";
	    //}

	    //echo $assetsdir;

		return create_zip($assets, $workspace.'/'.$sessionId.'/'.$outputfile, false, array($assetsdir.'/', $workspace.'/'.$sessionId.'/'), '');	
	}

    function dir_list($dir){ 
       foreach(array_diff(scandir($dir),array('.','..')) as $f)if(is_dir($dir.'/'.$f))$l[]=$f; 
       return $l; 
    }

    function file_list($dir,$extension){ 
       foreach(array_diff(scandir($dir),array('.','..')) as $f)if(is_file($dir.'/'.$f)&&(($extension)?ereg($extension.'$',$f):1))$l[]=$f; 
       return $l; 
    } 

    function create_zip($files = array(),$destination = '',$overwrite = false, $removePath = array(''), $addPath = '') {
	  //if the zip file already exists and overwrite is false, return false
	  if(file_exists($destination) && !$overwrite) { return false; }
	  //vars
	  $valid_files = array();
	  //if files were passed in...
	  if(is_array($files)) {
	    //cycle through each file
	    foreach($files as $file) {
	      //make sure the file exists
	      if(file_exists($file)) {
	        $valid_files[] = $file;
	      }
	    }
	  }
	  //if we have good files...
	  if(count($valid_files)) {
	    //create the archive
	    $zip = new ZipArchive();
	    if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
	      return false;
	    }
	    //add the files
	    foreach($valid_files as $file) {
	    	$filename = $file;
	    	foreach ($removePath as $removePattern) {
	    		$filename = str_replace($removePattern, '', $filename);
	    	}
	    	$filename = $addPath.$filename;
	    	$zip->addFile($file, $filename);
	    }
	    //debug
	    //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status,'<br>';
	    
	    //close the zip -- done!
	    $zip->close();
	    
	    //check to make sure the file exists
	    if(file_exists($destination)) {
	    	return $destination;
	    } else {
	    	return 0;
	    }
	  }
	  else
	  {
	    return false;
	  }
	}

	function add_files2zip($files = array(), $zipfile, $removePath = array(''), $addPath = ''){
	  //vars
	  $valid_files = array();
	  //if files were passed in...
	  if(is_array($files)) {
	    //cycle through each file
	    foreach($files as $file) {
	      //make sure the file exists
	      if(file_exists($file)) {
	        $valid_files[] = $file;
	      }
	    }
	  }
	  //if we have good files...
	  if(count($valid_files)) {
	    //create the archive
	    $zip = new ZipArchive();
	    if($zip->open($zipfile) !== true) {
	      return false;
	    }
	    //add the files
	    foreach($valid_files as $file) {
	    	$filename = $file;
	    	foreach ($removePath as $removePattern) {
	    		$filename = str_replace($removePattern, '', $filename);
	    	}
	    	$filename = $addPath.$filename;
	    	$zip->addFile($file, $filename);
	    }
	    //debug
	    //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status,'<br>';
	    
	    //close the zip -- done!
	    $zip->close();
	    
	    //check to make sure the file exists
	    if(file_exists($zipfile)) {
	    	return $zipfile;
	    } else {
	    	return 0;
	    }
	  }
	  else
	  {
	    return false;
	  }
	}

	function add_files2zipWithName($files = array(), $names = array(), $zipfile){
	  //vars
	  $valid_files = array();
	  //if files were passed in...
	  if(is_array($files)) {
	    //cycle through each file
	    foreach($files as $file) {
	      //make sure the file exists
	      if(file_exists($file)) {
	        $valid_files[] = $file;
	      }
	    }
	  }
	  //if we have good files...
	  if(count($valid_files)) {
	    //create the archive
	    $zip = new ZipArchive();
	    if($zip->open($zipfile) !== true) {
	      return false;
	    }
	    //add the files
	    $count = (int)0;
	    foreach($valid_files as $file) {
	    	$filename = $names[$count];
	    	$zip->addFile($file, $filename);

	    	$count++;
	    }
	    //debug
	    //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status,'<br>';
	    
	    //close the zip -- done!
	    $zip->close();
	    
	    //check to make sure the file exists
	    if(file_exists($zipfile)) {
	    	return $zipfile;
	    } else {
	    	return 0;
	    }
	  }
	  else
	  {
	    return false;
	  }
	}
?>