<?php

include get_template_directory() . "/Method.php";

class Controller {
	
	public function __construct() {
		
	}
	
	public function execute_action() {
		
		$action = isset($_REQUEST['my_action']) ? $_REQUEST['my_action'] : false;
		
		// check is there 
		if (strpos($action, '|') !== false) {

			list ($class, $action) = explode('|', $action);

			// clear class
			//$class = preg_replace('/[^a-zA-Z0-9_]+','',$class);
			$class = 'Controller_'.$class;
			
			if ($class == '' || $action == '') {
				die('No action selected.');
			}
			
			# try to execute action of selected class
			/*if (file_exists(get_template_directory() . "/Controller/".$class.".php")) {
				include get_template_directory() . "/Controller/".$class.".php";
			}*/
			
			
			if (class_exists($class)) {

				try {

					# if class of this script exists
					$instance = new $class();
					
					$result = Method::call(array($instance, $action));
					
					if ($_SERVER['QUERY_STRING']) {
						wp_redirect(dirname($_SERVER['REQUEST_URI']).'/');
						exit();
					}
					
				} catch (Exception $e) {
					die('Exception: '.$e->getMessage());
				}
			} else {
				die('Controller ['.$class.'] dont exists');
			}
		}
	}
}
