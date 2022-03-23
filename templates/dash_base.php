<!DOCTYPE HTML>
<html lang="en">
<?php include_once 'templates/head.php'; ?>
<body class=""> <!-- Alert :  alert-view --> <!-- Connect Wallet :  alert-view -->
<?php
    include_once 'templates/dash_header.php';

	foreach ($__page->sections as $page_section) {
		include_once $page_section;
	}
?>
</body>
</html>