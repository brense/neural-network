<?php

class InputLayer extends Layer {
	
	protected $_type = 'input';
	
	public function __construct(Array $parameters){
		if(isset($parameters['sizeX']) && isset($parameters['sizeY'])){
			for($i = 0; $i < ($parameters['sizeX'] * $parameters['sizeY']); $i++){
				$this->_members[$i] = new Sensor(0);
			}
		}
	}
	
	public function connect(){
		return false;
	}
	
	public function receive(Array $input){
		if(count($input) == count($this->_members)){
			for($n = 0; $n < count($input); $n++){
				if($input[$n] == 1){
					$this->_members[$n]->trigger();
				}
			}
		}
	}
	
}