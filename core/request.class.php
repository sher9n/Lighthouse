<?php

class Request {
    private $route = null;

    private $G = null;
    private $P = null;
    private $C = null;
    private $F = null;

    private $d = null;
    private $g = null;

    private $userAgent  = null;
    private $remotePort = null;
    private $httpReferer = null;
    private $httpReferer_forBack = null;
    private $requestURI = null;
    private $xmlHttpRequest = null;
    private $requestMethod = null;
    private $passBack = null;
    private $userPassBack = null;
    private $remoteAddr = null;

	public static function build() {

		$request = null;
		if(isset($_SESSION['__lh.request'])) {
			$request = unserialize($_SESSION['__lh.request']);
		}

		if($request instanceof Request) {
			$request->process();
			return $request;
		}
		else {
			return new Request();
		}
	}

	public function __destruct() {
	    $_SESSION['__lh.request'] = serialize($this);
	}

	public function __sleep() {
	    return array('passBack','remoteAddr');
	}

	public function __construct() {
		$this->process();
	}

	private function process() {

		$this->G = (object)array_map(array($this,'_clean'),$_GET);

        if(isset($this->G->route)) {
            $this->route = $this->G->route;
            unset($this->G->route);
        }

		$this->P = (object)array_map(array($this,'_clean'),$_POST);
		$this->C = (object)array_map(array($this,'_clean'),$_COOKIE);

		if(isset($_FILES) && (bool)count($_FILES)) {
			foreach ($_FILES as $elementName => $uploadData) {
				if(is_array($uploadData['error'])) {
					$this->F[$elementName] = array();
					foreach ($uploadData['error'] as $fileIndex => $error) {
						if($error==0) {
							array_push($this->F[$elementName],(object)array(
								'name' => $_FILES[$elementName]['name'][$fileIndex],
								'type' => $_FILES[$elementName]['type'][$fileIndex],
								'error' => $_FILES[$elementName]['error'][$fileIndex],
								'tmp_name' => $_FILES[$elementName]['tmp_name'][$fileIndex],
								'size' => $_FILES[$elementName]['size'][$fileIndex]
							));
						}
					}
				}
				else if($uploadData['error'] == 0) {
					$this->F[$elementName] = (object)$uploadData;
				}
			}
		}

		$this->g = (object)(array)$this->G;
		$this->d = (object)array_merge((array)$this->G,(array)$this->P,(array)$this->C,(array)$this->F);

		$this->userAgent  = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
        $this->remotePort = $_SERVER['REMOTE_PORT'];
        $this->requestURI = $_SERVER['REQUEST_URI'];
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->xmlHttpRequest = ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
        							|| ((isset($this->d->v)) && ($this->d->v == 'r')));

        if(property_exists($this->d, '__user_pb') || property_exists($this->d, '__pb')) {
        	if(property_exists($this->d, '__pb')) { $pb = $this->d->__pb; } else { $pb = $this->d->__pmg_user_pb; }
			$this->passBack = $this->userPassBack = rtrim(parse_url($pb,PHP_URL_PATH) . '?' . parse_url($pb,PHP_URL_QUERY) . '#' . parse_url($pb,PHP_URL_FRAGMENT),'?#');
			unset($this->d->{'__user_pb'}); unset($this->d->{'__pb'});
        }

        if(isset($_SERVER['HTTP_REFERER'])) {
            $this->httpReferer = $_SERVER['HTTP_REFERER'];
            if($_SERVER['HTTP_REFERER'] != referer_app_url.$_SERVER['REQUEST_URI']) {
                $this->httpReferer_forBack = $_SERVER['HTTP_REFERER'];
            }
        }
	}

	public function userPassBack(&$passBack) {
		if(is_null($passBack) && !is_null($this->userPassBack)) {
			$passBack = $this->userPassBack;
		}
		else if(!is_null($passBack) && is_null($this->userPassBack)) {
			$this->userPassBack = &$passBack;
		}
	}

	public function __set($property, $value) {
		if(in_array($property,array('m','o','a')) && property_exists(__CLASS__,$property)) {
            $this->{$property} = $this->filter($value);
            return true;
		}
        return false;
	}

	public function hasParam($propertyName) {
		return (property_exists($this->d,$propertyName));
	}

	public function getParam($propertyName) {
		if($this->hasParam($propertyName)) {
			return $this->d->{$propertyName};
		}

		throw new Exception(__METHOD__.' `'.$propertyName.'` not found');
	}

	public function get__PB($part=null) {
		if(is_null($part)) {
			return $this->passBack;
		}
		else {
			$d = parse_url($this->passBack); parse_str($d['query'],$d);
			return array_key_exists($part, $d) ? $d[$part] : null;
		}
		return null;
	}

	public function __get($property) {
        if(in_array($property,array('m','o','a','d','g','route')) && property_exists(__CLASS__,$property)) {
            return $this->{$property};
        }

        if($property == 'is_xmlHttpRequest') { return $this->xmlHttpRequest; }
		if($property == 'is_post') { return (strtoupper($this->requestMethod) == 'POST'); }
		if($property == 'is_get') { return (strtoupper($this->requestMethod) == 'GET');}
		if($property == 'is_delete') {return (strtoupper($this->requestMethod) == 'DELETE');}
        if($property == '__method') { return strtoupper($this->requestMethod); }
        if($property == '__uri') { return $this->requestURI; }
        if($property == '__pb') { $passBack = $this->passBack; $this->passBack = null; return $passBack; }
		if($property == '__passback') { $passBack = $this->userPassBack; $this->userPassBack = null; return $passBack; }
        if($property == '__httpReferer_forBack') { return (string)$this->httpReferer_forBack; }
        if($property == '__referer') {
            return (string)$this->httpReferer;
        	/*if(app_domain == substr(parse_url($this->httpReferer,PHP_URL_HOST),-strlen(app_domain))) {
				return (string)(parse_url($this->httpReferer,PHP_URL_PATH));
        	}
        	else {
				return (string)$this->httpReferer;
        	}*/
        }
        return false;
	}

	private function filter($data) {
		if(is_array($data)) {
			array_map(array($this,'filter'), $data);
		}
		else {
			return (mb_check_encoding($data, 'UTF-8')) ? $data : $this->filter(utf8_encode($data));
		}
	}

	private function _clean($data) {
		$cleaned = is_array($data) ? array_map(array($this,'_clean'), $data) : $data;
		return $cleaned;
	}

	public function getUserAgent() {
		return $this->userAgent;
	}

	public function getRemoteAddress() {
		return $this->remoteAddr;
	}

	public function getRemotePort() {
		return $this->remotePort;
	}

	public function getSession() {
		if(isset($_SESSION['session.owner'])) {
			$session =  (object)$_SESSION['session.owner'];
			$session->id = session_id();
			return $session;
		}
		return null;
	}

	public function getHeader($name=null) {
		if(!function_exists('getallheaders')) { return null; }
		$headers = getallheaders();

		if(!is_null($name) && array_key_exists($name,$headers )) {
			return $headers[$name];
		}
		return $headers;
	}
}
?>