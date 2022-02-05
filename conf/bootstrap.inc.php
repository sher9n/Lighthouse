<?php

	spl_autoload_register(function ($className) {

		$knownClasses = array(
			'Ctrl' => app_class_path . 'ctrl.class.php',
			'Request' => app_class_path. 'request.class.php',
			'Ds' => app_class_path . 'ds.class.php',
            'Controller' => app_class_path . 'controller.class.php',
            'Util' => app_class_path . 'utils.class.php',
		);

		if(array_key_exists($className, $knownClasses)) {
            require_once $knownClasses[$className];
		}
		else {
			$classPath = null;

			if(strpos($className, '\\') !== false) {

				$classFile = app_root.DS.strtolower(str_replace('\\','/',$className)).'.class.php';

				if(!file_exists($classFile)) {
                    $classFile = app_root.DS.str_replace('\\','/',$className).'.php';
                }

				if(file_exists($classFile)) { $classPath =  $classFile; }
			}

			if(is_file($classPath)) {
				require_once $classPath;
			}
		}
	});
?>