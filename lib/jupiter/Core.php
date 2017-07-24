<?php

namespace jupiter;

class Core
{
	
	static function run(){

		try{
			spl_autoload_register('self::registerAutoload');
			self::loadConfig();

			$params = explode('/',$_GET['page']);
			$controller = !empty($params[0]) ? $params[0] : 'index';
			$action = isset($params[1]) ? $params[1] : 'index';
			$action = ( $action == "" ) ? "indexAction" : $action."Action";

			if(!file_exists(ROOT.'app/controllers/'.$controller.'Controller.php')){

				throw new \Exception(404);
			}
			else{

				$controller = ucfirst($controller)."Controller";
				$controller = "app\controllers\\".$controller;
				$controller = new $controller();
			}
			if (method_exists($controller, $action)){

				unset($params[0]);
				unset($params[1]);

				session_start();
				call_user_func_array(array($controller,$action),$params);
			}
			else{
				throw new \Exception(500);
			}
		}
		catch (\Exception $e){

	       	if ($e->getMessage() === "404") {

	            header("HTTP/1.1 404 Not Found");
	        }
	        if ($e->getMessage() === "500") {

	            header("HTTP/1.1 500 Internal Server Error");
	        }
	    }
	}

	static function registerAutoload($class){
		
		$class = explode("\\", $class);

		if(file_exists(ROOT.'lib/jupiter/'.$class[1].'.php')){
			require_once(ROOT.'lib/jupiter/'.$class[1].'.php');
		}
		if(count($class) > 2 && file_exists(ROOT.'app/controllers/'.$class[2].'.php')){
			require_once(ROOT.'app/controllers/'.$class[2].'.php');
		}
		if(count($class) > 2 && file_exists(ROOT.'app/models/'.$class[2].'.php')){
			require_once(ROOT.'app/models/'.$class[2].'.php');
		}
	}

	static function loadConfig(){

		$db = parse_ini_file(ROOT.'app/config.ini');
		foreach ($db as $key => $value){
			$function = "set$key";
			Model::$function($value);
		}
	}
}