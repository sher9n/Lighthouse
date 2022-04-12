<!DOCTYPE HTML>
<html lang="en">
<?php include_once 'templates/head.php'; ?>
<body class="<?php echo (__ROUTER_PATH != '/rewards')?'card-fixed-show':''; ?>">
<?php
    include_once 'templates/header.php';

	foreach ($__page->sections as $page_section) {
		include_once $page_section;
	}
?>
</body>
</html>