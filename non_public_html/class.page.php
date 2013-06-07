<?php

class page {

	// Assign the public variables
	public $title = "";
	public $shortlink = "";
	public $right_section = "";
	public $keywords = "";
	public $description = "";

	function construct_page() {

		// This is a new page so start a new session
		start_session();

		//$page_full_title = $this->title .  ' - ' . DOMAIN . REMOTE_TLD . ' URL Shortener';
		$page_full_title = strtoupper(DOMAIN . '.' . REMOTE_TLD) . ' URL Shortener';
		// First we log the page
		bbclone_log($this->title);
		
		$content = '<!doctype html>
<html class="no-js">
	<head>
		<title>' . $page_full_title . '</title>
		<!-- CSS reset file -->
		<link rel="stylesheet" href="css/reset.css" />

		<!-- All my styles -->
		<link rel="stylesheet" href="css/style.css" />

		<!-- Add some stylesheets that are for the time being seperate
		but will at some point be combined  -->
		<link rel="stylesheet" href="css/ribbon.css" />
		<link rel="stylesheet" href="css/overlay.css" />

		<!-- Add a short link -->
		<link rel="shortlink" href="http://gewd.co/' . $this->shortlink . 
		'" />

		<!-- Add a sitemap  -->
		<link rel="sitemap" href="sitemap.xml" />

		<!-- I will probably be using the jquery library for a few things -->
		<!-- This includes the jQuery tools -->
		<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>

		<!-- I prefer this script to handle my placeholders -->
		<script src="js/jquery.placeholder.min.js"></script>

		<!-- My Javascripts -->
		<script src="js/default.js"></script>

		<!-- Integrate modernizr to detect things like css gradients
		     This is until I get everything sorted then I will look 
			 at fallbacks where they should be used -->
			 <!--
		<script src="js/modernizr.custom.01153.js"></script>
		-->

		<!-- I am also not using less at the minute and it will not be
		     in the final version but for convenience I shall be using 
			 it until the style etc is settled -->
		<!--
		<script src="js/less-1.3.0.min.js"></script>
		-->
	</head>

	<body>
		<header>
			<h1><a 
					href="http://gewd.co"
					title="The site&#039;s Home page"
					rel="home"
				>' .  strtoupper(DOMAIN . '.' . REMOTE_TLD) . '</a>
		</h1>
	</header>
		<div class="content">
			<div class="ribbon">
				<div class="ribbon-content"><a href="http://gewd.co/fa7a" title="View this project on github">Folk me on Github</a></div>
			</div>
			
			<section class="main_content">
				' . $this->main_content . '
			</section>
			<!--
			<p>
				<a class="left-link" href="how-to.php">How to...</a><br />
				<a class="left-link" href="other-stuff">Other stuff</a>
			</p>
			-->
			<footer>
				<a href="http://grandadevans.com/get-in-touch.php" title="Temporary link to MY contact page">Contact</a>
				<a href="credits.php"
					rel="#overlay"
					>Credits</a>
				' . copy_year('2011') . '
				
			</footer>
		</div>
		<!-- overlayed element -->
		<div class="apple_overlay" id="overlay">
			<!-- the external content is loaded inside this tag -->
			<div class="contentWrap"></div>
		</div>
		<!-- Start of StatCounter Code for Default Guide -->
		<script type="text/javascript">
		var sc_project=7793828; 
		var sc_invisible=1; 
		var sc_security="4ccc2747"; 
		</script>
		<script type="text/javascript"
		src="http://www.statcounter.com/counter/counter.js"></script>
		<noscript><div class="statcounter"><a title="hits counter"
					href="http://statcounter.com/free-hit-counter/"
					target="_blank"><img class="statcounter"
					src="http://c.statcounter.com/7793828/0/4ccc2747/1/"
					alt="hits counter"></a></div></noscript>
		<!-- End of StatCounter Code for Default Guide -->
	</body>
</html>';

return($content);

}
}
function copy_year($start)
{
	$copy = '<span class="light-on-dark"><a href="https://plus.google.com/114393030139392236412?rel=author" rel="author me">Copyright &copy; ' . date('Y') . ' John Evans</a></span>';
	$link = $copy;
	return ($link);
}

?>