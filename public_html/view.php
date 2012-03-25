<?php
require('../non_public_html/prelims.php');
if (is_short_valid($_GET['short'])) {
	get_long_url_and_go($_GET['short'], $DBH);
}
?>
