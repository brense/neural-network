<?php

class AutoLoader {
	
	private $_sources = array();
	private static $_loaded = array();
	
	public static $instance;
		
	public static function instance(){
		if(empty(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	private function __construct(){
		$this->_sources[] = '';
		
		spl_autoload_register(array($this, 'loadClass'));
	}
	
	private function loadClass($class){
		if(!in_array($class, self::$_loaded)){
			$path = str_replace('\\', '/', $class);
			$path = str_replace('_', '/', $class);
			$found = false;
			foreach($this->_sources as $source){
				if(file_exists($source . $path . '.php')){
					include($source . $path . '.php');
					spl_autoload($class);
					self::$_loaded[] = $class;
					$found = true;
					break;
				}
			}
			if(!$found){
				throw new \Exception('class ' . $class . ' not found');
			}
		}
	}
	
	public function loadedClasses(){
		return self::$_loaded;
	}

}

$autoloader = Autoloader::instance();