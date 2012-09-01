<?php
	require_once('config.php');
	require_once('worker.php');

	if(isset($_GET['resolution']) && $_GET['resolution'] != "") {
		$resolution = $_GET['resolution'];

		if($resolution == 'x90') {
			$choosenResoltuion = (int)0;
		}  else if ($resolution == 'x135') {
			$choosenResoltuion = (int)1;
		} else {
			$choosenResoltuion = (int)$resolution;
		}
	} else {
		header("Location: index.php");
	}

	if(isset($_GET['sessionId']) && $_GET['sessionId'] != "") {
		$sessionId = $_GET['sessionId'];
	} else {
		header("Location: index.php");
	}

	//Try to create the filenames
	$outputfile = $exportPrefix.$sessionId.'_'.$possibleResolutions[$choosenResoltuion].$exportSuffix;
	$finalthemefile = $workspace.'/'.$sessionId.'/'.$outputfile;

	if(!file_exists($finalthemefile)) {
		header("Location: index.php");
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js" lang="en"><!--<![endif]-->
	<head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>MIcons Download Page</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
		<link rel="icon" href="http://www.tundem.com/wp/wp-content/uploads/Homepage_Logo_Adressbar1.png" type="image/x-icon" /> 

		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

		<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="css/download_base.css" />
        <link rel="stylesheet" type="text/css" href="css/download_cssbutton.css" />
        <link rel="stylesheet" type="text/css" href="css/share_tooltips.css" />
    </head>
    <body>
    	</br></br></br></br></br></br></br></br></br></br>
		<div class="container">
		        <header>
	                <h1>MIcons <span>Project</span></h1>
	                <h2>a new iconset for your -MIUI-</h2>
				</header>
				<section>
	                <div id="container_buttons">
	                    <p>
	                    	<br><br>
	                        <a class="a_demo_five" href="<?php echo $rootdir.$finalthemefile; ?>">
	                            Download now!
	                        </a>
	                    </p>
	                </div>
				</section>
			<ul class="tt-wrapper" style="width: <?php echo $profilesActive * 72 ?>px;">
				<?php if($gplusProfile != '') { ?><li><a class="tt-gplus" target="_blank" href="https://plus.google.com/u/0/<?php echo $gplusProfile; ?>"><span>Google Plus</span></a></li><?php } ?>
				<?php if($twitterProfile != '') { ?><li><a class="tt-twitter" target="_blank" href="http://twitter.com/<?php echo $twitterProfile; ?>"><span>Twitter</span></a></li><?php } ?>
				<?php if($dribbbleProfile != '') { ?><li><a class="tt-dribbble" target="_blank" href="<?php echo $dribbbleProfile; ?>"><span>Dribbble</span></a></li><?php } ?>
				<?php if($facebookProfile != '') { ?><li><a class="tt-facebook" target="_blank" href="<?php echo $facebookProfile; ?>"><span>Facebook</span></a></li><?php } ?>
				<?php if($linkedinProfile != '') { ?><li><a class="tt-linkedin" target="_blank" href="<?php echo $linkedinProfile; ?>"><span>LinkedIn</span></a></li><?php } ?>
				<?php if($forrstProfile != '') { ?><li><a class="tt-forrst" target="_blank" href="<?php echo $forrstProfile; ?>"><span>Forrst</span></a></li><?php } ?>
			</ul>
	    </div>

	    <div class="container">
			<footer>
				<h2>Credits</h2>
			    <h3>I've to say thanks for the great css ressources from <a href="http://tympanus.net/codrops/">codrops.com</a> and <a href="http://livetools.uiparade.com/">uiparade.com</a>, without them this site wouldn't look that good.</h3>
			    <h3>The rest of this script is made by Mike Penz. You can find more of his work here: <a href="http://penz.tundem.com">His portfolio.</a></h3>
			</footer>
		</div>
    </body>
</html>
