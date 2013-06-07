<?php
echo '00';
exit;
require('../non_public_html/prelims.php');
echo '1';
if (is_short_valid($_GET['short'])) {
    echo '2';
	get_long_url_and_go($_GET['short'], $DBH);
}
else echo '3';
?>
