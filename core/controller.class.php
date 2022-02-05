<?php
class Controller {

	public function __construct() {
		$this->__lh_request = &$request;
		date_default_timezone_set('UTC');
	}

}
?>