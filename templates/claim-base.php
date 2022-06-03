<!DOCTYPE HTML>
<html lang="en">
<?php include_once 'templates/claim-head.php'; ?>
<body>
<?php
	foreach ($__page->sections as $page_section) {
		include_once $page_section;
	}
?>
</body>
</html>