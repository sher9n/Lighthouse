<!DOCTYPE HTML>
<html lang="en">
<?php include_once 'templates/admin-head.php'; ?>
<body>
<?php
	foreach ($__page->sections as $page_section) {
		include_once $page_section;
	}
?>
</body>
</html>