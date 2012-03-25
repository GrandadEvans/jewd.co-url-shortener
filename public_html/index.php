<?php
require("../non_public_html/prelims.php");

// If the form has been submitted (no-js) then we want to action it

// There is no point in shortening a URL less than 11 CHAR as it will be no shorter
if ((isset($_POST['input_long']) && strlen($_POST['input_long']) > 1)) {

	// Send details to form processor
	require('../non_public_html/url-handler.php');
}
?><!doctype html>
<html>
	<head>
		<title>JEWD.CO URL Shortener</title>
		<link rel="stylesheet" href="css/style.css" />
		<style src="js/default.js"></style>
	</head>

	<body>
		<div class="content">
			<h1><a href="<?php echo SERVER; ?>" title="Home Page"><abbr title="John Evans Web Design">jewd</abbr>.co</a></h1>

			<?php
				if (isset($_SESSION['short_url'])) {
					echo '<p class="shortened">Your short URL is:<br><a href="' . SERVER . '/' . $_SESSION['short_url'] . '">' . SERVER . '/' . $_SESSION['short_url'] . '</a></p>';
					unset($_SESSION['short_url']);
				}
			?>
			<form method="post" action="">
				<fieldset>
					<legend>URL Details</legend>

					<label for="input_long">Enter the <abbr 
							title="Universal Resource Locator">URL</abbr> 
						to be shortened</label>
					<input type="url" name="input_long" value="">

					<input type="submit" value="Shorten this URL" />
				</fieldset>
			</form>
			<!--
			<p>
				<a class="left-link" href="how-to.php">How to...</a><br />
				<a class="left-link" href="other-stuff">Other stuff</a>
			</p>
			-->
			<footer>
				<!--<a href="privacy.php">Privacy Policy</a>-->
				<a href="http://www.evanswebdesign.co.uk" title="My Web site">Copyright &copy;2012 John Evans</a>
				<a href="http://www.evanswebdesign.co.uk/contact.php" title="Temporary link to MY contact page">Contact</a>
			</footer>
		</div>
	</body>
</html>




