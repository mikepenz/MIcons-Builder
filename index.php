<?php
	require_once("config.php");
	require_once("worker.php");
	require_once("ConfigManager.php");

	$resolution = $possibleResolutions[0];
	if(isset($_GET['hres'])) {
		$resolution = $possibleResolutions[1];
	}
	$iconcount = count(file_list($iconsdir."/".$resolution, ""));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>MIcons Configurator</title>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
		<link rel="icon" href="http://www.tundem.com/wp/wp-content/uploads/Homepage_Logo_Adressbar1.png" type="image/x-icon" /> 


		<link href='http://fonts.googleapis.com/css?family=Merienda+One' rel='stylesheet' type='text/css' />
        <link rel="stylesheet" type="text/css" href="css/configurator.css" />
		<link rel="stylesheet" type="text/css" href="css/elastislide.css" />
		<link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
    	<link rel="stylesheet" type="text/css" href="css/stylesheet_button.css" />
        <link rel="stylesheet" type="text/css" href="css/share_tooltips.css" />
		<!--<script src="js/json2.js" type="text/javascript"></script>-->


		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
		<script type="text/javascript" src="js/jquery.tmpl.min.js"></script>

		<script type="text/javascript">
			var processing = false;

			var configuration = new Array();
			$().ready(function() {

				$("li").click(function() {
					var id = $(this).attr('id');

					$(this).parent().children().removeClass("es-carousel-selected");
					$(this).addClass('es-carousel-selected');

					var subArray = new Array();
					subArray[0] = $(this).attr('folder');
					subArray[1] = $(this).attr('name');

					configuration[id] = subArray;

					var configurationOutput = '';
					for(var index in configuration) {
						//folder //appname //image
					  configurationOutput = configurationOutput + configuration[index][0] + "<?php echo $singleConfigDivider; ?>" + index + "<?php echo $singleConfigDivider; ?>" + configuration[index][1] + "<?php echo $configDivider; ?>";
					}

					$('#configuration').val(configurationOutput);
				});

				$("#processit")
				    .show()
				    .ajaxStart(function() {
				        $(this).hide("slow");
				    })
				    .ajaxStop(function() {
				        $(this).show("slow");
				    })
				;

				$("#loadingDiv")
				    .hide()
				    .ajaxStart(function() {
				        $(this).show("slow");
				    })
				    .ajaxStop(function() {
				        $(this).hide("slow");
				    })
				;
			});

			

			function processTheme() {
				if(!processing) {
					processing = true;
					$.ajax({
					  type: "POST",
					  url: "process.php",
					  data: { resolution: $("#resolution").val(), folderstyle: $("#folderstyle").val(), configuration: $("#configuration").val(), iconscount: $("#iconscount").val() }
					}).done(function( msg ) {
					  	processing = false;
						if(msg.indexOf("error") == -1) {
							self.location = "gettheme.php" + msg;
						} else {
							alert( "There was an issue! Please try again. (Don't modify the configuration manually!)" );
						}
					});
				}
			}
		</script>

		<noscript>
			<style>
				.es-carousel ul{
					display:block;
				}
			</style>
		</noscript>
    </head>
    <body>
		<div class="container">
			<header>
			    <h1><?php echo $headerText; ?></h1>
			    <h2><?php echo $subheaderText; ?></h2>
			    <h3>Current iconcount: <span><?php echo $iconcount; ?></span></h3>
			</header>


			<form method="POST" action="" id="configurator" name="configurator">
				<p>
					<label><?php echo $welcomeText; ?></label>
				</p>
				<p>
					<select name="resolution" id="resolution">
						<?php foreach($possibleResolutions as $resolutionSel) { ?>
							<option name="<?php echo $resolutionSel; ?>" value="<?php echo $resolutionSel; ?>"><?php echo $resolutionSel; ?></option>
						<?php } ?>
					</select>
				</p>
				<p>
					<select name="folderstyle" id="folderstyle">
						<?php 
							$count = (int)0;
							foreach($possibleSystemstyles as $systemstyle) 
							{ 
						?>
							<option name="<?php echo $systemstyle; ?>" value="<?php echo $count; ?>"><?php echo $systemstyle; ?></option>
						<?php 
							$count ++;
							} 
						?>
					</select>
				</p>
				<p>
					<textarea rows="10"  class="boxsizingBorder" id="configuration" name="configuration"></textarea><br>
					<label><?php echo $configDescriptionText; ?></label>
					<input type="hidden" name="iconscount" id="iconscount" value="<?php echo $iconcount; ?>" />
				</p>
			</form>
			<div>
				<button id="processit" class="a_demo_one" style="cursor:pointer" onClick="processTheme()">
				    Pack my theme!
				</button>
				<div id="loadingDiv"><p><img src="images/ajax-loader-bar.gif"></img><br>Processing...</p></div>
			</div>
			<div>

				<?php
					$count = (int)1;
				    $alternative_directories = dir_list($alternativesdir."/".$resolution, "");
				    foreach ($alternative_directories as $arrKey => $arrVal) {
						$config = ConfigManager::read($alternativesdir."/".$resolution."/".$arrVal."/conf.m");

						if($config == false) {
							$config = array($arrVal);
						}

						foreach ($config as $value) {
							if($value == "") {
								break;
							}
				?>
				<!-- Elastislide Carousel -->

				<div class="column" style="width:23%">
					<h3><?php echo $value; ?></h3>
					<div id="carousel-<?php echo $count; ?>" class="es-carousel-wrapper">
						<div class="es-carousel">
							<ul>
								<?php 
									$alternative_files = file_list($alternativesdir."/".$resolution."/".$arrVal, ".png");
									$countImage = (int)1;
					    			foreach ($alternative_files as $arrKeyFile => $arrValFile) {
					    		?>
					    			<li id="<?php echo $value; ?>" name="<?php echo $arrValFile; ?>" folder="<?php echo $arrVal; ?>"><a href="#"><img src="<?php echo $alternativesdir."/".$resolution."/".$arrVal."/".$arrValFile; ?>" alt="<?php echo "image".$countImage; ?>" /></a></li>
					    		<?php
					    			$countImage ++;
					    			}
								?>
							</ul>
						</div>
					</div>
				</div>
				<?php
						$count ++;
						}
				    }
				?>
			</div>


			<div class="clr"></div>

			<ul class="tt-wrapper" style="width: <?php echo $profilesActive * 72 ?>px;">
				<?php if($gplusProfile != '') { ?><li><a class="tt-gplus" target="_blank" href="https://plus.google.com/u/0/<?php echo $gplusProfile; ?>"><span>Google Plus</span></a></li><?php } ?>
				<?php if($twitterProfile != '') { ?><li><a class="tt-twitter" target="_blank" href="http://twitter.com/<?php echo $twitterProfile; ?>"><span>Twitter</span></a></li><?php } ?>
				<?php if($dribbbleProfile != '') { ?><li><a class="tt-dribbble" target="_blank" href="<?php echo $dribbbleProfile; ?>"><span>Dribbble</span></a></li><?php } ?>
				<?php if($facebookProfile != '') { ?><li><a class="tt-facebook" target="_blank" href="<?php echo $facebookProfile; ?>"><span>Facebook</span></a></li><?php } ?>
				<?php if($linkedinProfile != '') { ?><li><a class="tt-linkedin" target="_blank" href="<?php echo $linkedinProfile; ?>"><span>LinkedIn</span></a></li><?php } ?>
				<?php if($forrstProfile != '') { ?><li><a class="tt-forrst" target="_blank" href="<?php echo $forrstProfile; ?>"><span>Forrst</span></a></li><?php } ?>
			</ul>
		</div>

		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script type="text/javascript" src="js/jquery.elastislide.js"></script>

		<script type="text/javascript">
			<?php
			    for ($i = 0; $i < $count; $i++)
			    {
			?>
				$('#carousel-<?php echo $i; ?>').elastislide({
					imageW 		: 60,
					minItems	: 1,
					border		: 0
				});
			<?php
				}
			?>
			
		</script>

		<div class="container">
			<footer>
				<h2>Credits</h2>
			    <h3>I've to say thanks for the great css ressources from <a href="http://tympanus.net/codrops/">codrops.com</a> and <a href="http://livetools.uiparade.com/">uiparade.com</a>, without them this site wouldn't look that good.</h3>
			    <h3>The rest of this script is made by Mike Penz. You can find more of his work here: <a href="http://penz.tundem.com">His portfolio.</a></h3>
			</footer>
		</div>
    </body>
</html>