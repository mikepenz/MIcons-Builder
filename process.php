<?php
	require_once('config.php');
	require_once('worker.php');

	if(isset($_POST['resolution']) && $_POST['resolution'] != "") {
		$resolution = $_POST['resolution'];
	}

	if (isset($_POST['folderstyle'])) {
		$folderstyle = $_POST['folderstyle'];
	} else {
		echo "error";
		return;
	}

	if (isset($_POST['iconscount'])) {
		$iconscount = $_POST['iconscount'];
	}

	if (isset($_POST['configuration'])) {
		$configuration = $_POST['configuration'];
	}

	$hash = $folderstyle.$iconscount.$configuration;
	if($hash != "") {
		$sessionId = md5($resolution.$hash);
	} else {
		echo "error";
		return;
	}
	
	//GET resolution
	if(isset($resolution)) {
		if($resolution == 'x90') {
			$choosenResoltuion = (int)0;
		}  else if ($resolution == 'x135') {
			$choosenResoltuion = (int)1;
		} else {
			$choosenResoltuion = (int)$resolution;
		}
	} else {
		$choosenResoltuion = (int)1;
	}

	//Try to create the filenames
	$outputfile = $exportPrefix.$sessionId.'_'.$possibleResolutions[$choosenResoltuion].$exportSuffix;
	$finalthemefile = $workspace.'/'.$sessionId.'/'.$outputfile;

	//GET session id
	if(!file_exists($finalthemefile)) {
		//ReCreate outputfiles with new sessionId (perhaps)
		$outputfile = $exportPrefix.$sessionId.'_'.$possibleResolutions[$choosenResoltuion].$exportSuffix;
		$finalthemefile = $workspace.'/'.$sessionId.'/'.$outputfile;

		//Clean-up
		if(!file_exists($finalthemefile)) {
			//create the icons zip
		    $iconszip = create_icons_zip($workspace, $iconsdir, $possibleResolutions[$choosenResoltuion], $possibleResolutionNames[$choosenResoltuion], $sessionId, $tempExportName);
		    //echo 'icons created<br>';

		    if($iconszip != "") {
		    	//Add the icon-res folder to the set
				$iconszip = add_system_icons_to_zip($workspace, $systemiconsdir, $sessionId, $possibleResolutions[$choosenResoltuion], $possibleResolutionNames[$choosenResoltuion], $possibleSystemstyles[$folderstyle], $iconszip);
				//echo 'icons with systemicons created<br>';

			    if($iconszip != "") {
			    	if(isset($configuration) && $configuration != "") {
			    		//Add our configurated icons ;) (if choosen)
						$iconszip = add_configurated_icons_to_zip($workspace, $alternativesdir, $configuration, $sessionId, $possibleResolutions[$choosenResoltuion], $iconszip, $configDivider, $singleConfigDivider);
						//echo 'replaced configurated icons<br>';
					}

				    if($iconszip != "") {
				    	//Now create the whole theme-package
					    $finalthemefile = create_theme_mtz($workspace, $assetsdir, $sessionId, $assetFiles, $iconszip, $outputfile);
					    //echo 'theme created<br>';
					    
					    //remove the icons zip because we don't need it   
					    if(file_exists($iconszip)) {
					    	unlink($iconszip);
					    }
				    } 
			    }
		    }
	    }
   	}

	if (isset($sessionId) && isset($resolution) && file_exists($finalthemefile)) {
		echo "?sessionId=".$sessionId."&resolution=".$resolution;
	} else {
		echo "error";
	}
?>