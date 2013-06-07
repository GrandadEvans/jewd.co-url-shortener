<?php
require("../non_public_html/prelims.php");

// if the form has been submitted then send the form for processing
if (isset($_POST['input_long']) && strlen($_POST['input_long']) > 1) {
	require('../non_public_html/url-handler.php');
}

$page = new page;
$page->page_short_title = 'Home Page';
$page->shortlink = 'd5bf';
$page->keywords = 'URL Shortener';
$page->description = 'A simple URL shortener';

if (isset($_SESSION['error_msg'])) {
			$page->main_content = '
				<header>
					<h1>There was an error</h1>
				</header>
				<p>' . $_SESSION['error_msg'] . '</p>
				';
				unset($_SESSION['error_msg']);
			} elseif (isset($_SESSION['short_url'])) {
	$page->main_content = '
	<div class="shortened">
				<p>Your Shortened URL is&hellip;<br />
		   <!-- this unlinked version is for users who are not aware 
		        of things like right click and select ??? This will 
				enable them to copy it straight away. This node will be 
				deleted and replaced with a copy button if the user has JS 
				enabled -->
		   <span class="shortened_unlinked">
			   <br />' . 'http://gewd.co/' . $_SESSION['short_url'] . '
			</span>
			<p>&nbsp;</p>
		</div>
			';
			unset($_SESSION['short_url']);
		} 
	$page->main_content .= '
<form method="post" action="">
				<fieldset>
					<legend>URL Details</legend>

					<label for="input_long">Enter the <abbr 
							title="Uniform (or Universal) Resource Locator">URL</abbr> 
						to be shortened</label>
					<input type="url" name="input_long" placeholder="e.g. http://www.GrandadEvans.com" />

					<input type="submit" value="Shorten this URL" />
				</fieldset>
			</form>
			';
$main_content = $page->construct_page();
echo $main_content;


