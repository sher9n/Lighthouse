<?php

abstract class Ctrl {
	protected $__lh_request = null;
	protected $__sessionOwner = null;
	
	protected function validateInputs($fields){
		foreach ($fields as $field => $fieldInfo){
			foreach (explode(',', $fieldInfo[1]) as $ruleString) {

				$ruleOp = explode('|', $fieldInfo[1]);
				$rule = $ruleOp[0];
				$op = isset($ruleOp[1]) ? $ruleOp[1] : '';
				$val = isset($ruleOp[2]) ? $ruleOp[2] : false;
				
				switch ($rule) {
					case 'required':
						if(!$this->hasParam($field) || ($this->hasParam($field) && $this->getParam($field) == '')){
							throw new Exception ($fieldInfo[0].' is required');
						}
						break;
						
					case 'requiredif':
						if(($this->hasParam($op) && $this->getParam($op) != '')
							&& (!$this->hasParam($field) || ($this->getParam($field) == '' && $val == false) || ($val !== false && $this->getParam($op) === $val && $this->getParam($field) == '')) ) {
							throw new Exception ($fieldInfo[0].' needs a value');
						}
						break;
						
					case 'email':
						if($this->hasParam($field) && !filter_var($this->getParam($field), FILTER_VALIDATE_EMAIL)){
							throw new Exception ($fieldInfo[0].' is not a valid email');
						}
						break;
						
					case 'match':
						if($this->hasParam($field) && $this->hasParam($op) 
							&& $this->getParam($field) != $this->getParam($op)){
							throw new Exception ($fieldInfo[0].' should match with `'.$fields[$op][0].'`');
						}
						break;
						
					case 'file':
						if($this->hasParam($field) && !$this->getParam($field) instanceof stdClass){
							throw new Exception ($fieldInfo[0].' is not a valid file');
						}
						break;

					case 'ts':
						if($this->hasParam($field) && !Utils::is_timestamp($this->getParam($field))){
							throw new Exception ($fieldInfo[0].' is not a valid time');
						}
					break;
				}
			}
		}
	}
	
	protected function JSONPrint($flag, $data = null, $message = 'N/A'){
		$out = array('success' => $flag, 'message' => $message);
		if(!is_null($data)) {
			$out['data'] = $data;
		}
		
		$out = json_encode($out, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
		
		header('HTTP/1.1 200 OK');
		header('Content-Length: ' . strlen($out));
		header('Content-type:application/json');
		echo $out;
		exit();
	}

	protected function pageNotFound() {
		$redirectMessage = array('page notfound',$this->__lh_request->is_xmlHttpRequest?'json':'header',__ROUTER_PATH);
		throw new Exception(implode('-',$redirectMessage), 404);
	}

	protected function hasPermission($passBack=false) {
		if($this->__sessionOwner instanceof User) {
			$passBack?header('Location: /switch?__pb='.urlencode($passBack)):header('Location: /dash');
			exit();
		}
		else {
			return true;
		}

		header('Loation:/dash');
	}

	protected function isAuthenticated($passBack=false, $object = false, $className = false) {

		if ($className !== false && strlen($className)) {
			if (class_exists($className) && is_a($object, $className)) {
				return true;
			}
		}
		else if($this->__sessionOwner instanceof User) { return true; }
		$redirectMessage = array('auth required',$this->__lh_request->is_xmlHttpRequest?'json':'header');

		if($passBack && is_string($passBack)) {
			array_push($redirectMessage, $passBack);
		}
		throw new Exception(implode('-',$redirectMessage), 401);
	}

	protected function hasParam($propertyName) {
		return $this->__lh_request->hasParam($propertyName);
	}

	protected function getParam($propertyName) {
		return $this->__lh_request->getParam($propertyName);
	}

	public function __construct(Request $request) {
		$this->__lh_request = &$request;

		date_default_timezone_set('UTC');

        if(is_callable(array($this,'pre_init'))) {
        	$this->pre_init();
        }

        try {
			$this->init();
        }
        catch (Exception $e) {
        	if($e->getCode() == 404) {
				if($this->__lh_request->is_xmlHttpRequest) {
        			header('Content-type: application/json');
        			echo json_encode(array(
        				'success' => false,
        				'code' => $e->getCode(),
        				'message' => 'Page not found'
        			));
        			exit();
        		}
        		else {
        			ob_start();
        			header('HTTP/1.0 404 Not Found');
	        		$__page = (object)array(
	        			'title' => Utils::get_page_title('Page Not Found'),
	        			'sections' => array(
	        				app_core_path.'/default/tpl/404.php'
	        			),
	        			'js' => array()
	        		);
	        		require_once '../templates/base.min.php';
	        		ob_end_flush();
	        		exit();
        		}
        	}
        	else {
        		throw $e;
        	}
        }

		if(is_callable(array($this,'post_init'))) {
			$this->post_init();
		}
	}

	abstract protected function init();
}
?>