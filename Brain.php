<?php

class Brain {
	
	private $_id;
	private $_layers = array();
	private static $_instance = null;
	private $_triggered = array();
	private $_outputValues = array();
	private $_answer;
	private $_input;
	
	private function __construct(Array $layers, Array $outputValues = array(), $autoconnect = true){
		$flat = array();
		array_walk_recursive($layers, create_function('&$v, $k, &$t', '$t[] = $v;'), $flat);
		$this->_id = md5(implode($flat));
		
		Memory::instance($this->_id);
		
		$outputLayer;
		foreach($layers as $layer){
			$l = ucfirst($layer['type']) . 'Layer';
			$curLayer = new $l($layer['parameters']);
			$this->_layers[] = $curLayer;
			
			if($autoconnect && isset($prevLayer)){
				$curLayer->connect($prevLayer);
			}
			$prevLayer = $curLayer;
			$outputLayer = $curLayer;
		}
		
		for($n = 0; $n < count($outputLayer->members); $n++){
			if(!isset($outputValues[$n])){
				$outputValues[$n] = $n;
			}
			$this->_outputValues[$outputLayer->members[$n]->id] = $outputValues[$n];
		}
	}
	
	public static function instance(Array $layers = array(), Array $outputValues = array(), $autoconnect = true){
		if(!isset(self::$_instance)){
			self::$_instance = new self($layers, $outputValues, $autoconnect);
		}
		return self::$_instance;
	}
	
	public function input(Array $input, $answer = null){
		$this->_input = $input;
		$this->_answer = $answer;
		foreach($this->_layers as $layer){
			if($layer instanceof InputLayer){
				$layer->receive($input);
				break;
			}
		}
	}
	
	public function getOutput(){
		foreach($this->_layers as $layer){
			if($layer instanceof OutputLayer){
				foreach($layer->members as $member){
					if(in_array($member, $this->_triggered)){
						return $this->_outputValues[$member->id];
					}
				}
			}
		}
		return 'null';
	}
	
	public function backPropagate($output){
		$layer;
		$desired = array();
		$wrong = array();
		foreach($this->_layers as $l){
			if($l instanceof OutputLayer){
				$layer = $l;
				break;
			}
		}
		foreach($layer->members as $member){
			if($this->_outputValues[$member->id] == $this->_answer && !in_array($member, $this->_triggered)){
				$desired[] = $member;
			} else if($this->_outputValues[$member->id] != $this->_answer && in_array($member, $this->_triggered)){
				$wrong[] = $member;
			}
		}
		
		$layer->backPropagate($this->_triggered, $desired, $wrong);
		
		Memory::instance()->backPropagate($this->_answer, $this->_input, $output);
	}
	
	public function showStructure(){
		foreach($this->_layers as $layer){
			echo ucfirst($layer->type) . " layer\n";
			foreach($layer->members as $member){
				if($member instanceof Sensor){
					echo 'sensor(' . count($member->synapses) . ')';
				} else {
					echo 'neuron(' . count($member->dendrites) . ', ' . count($member->synapses) . ')';
				}
				if($layer instanceof OutputLayer){
					echo ' - Output value: ' . $this->_outputValues[$member->id];
				}
				echo "\n";
			}
			echo "\n";
		}
	}
	
	public function getNextLayer(Layer $layer){
		$next = false;
		foreach(array_reverse($this->_layers) as $l){
			if($next){
				return $l;
			}
			if($l === $layer){
				$next = true;
			}
		}
		return false;
	}
	
	public function __get($name){
		switch($name){
			case 'triggered':
				return $this->_triggered;
				break;
			case 'answer':
				return $this->_answer;
				break;
		}
	}
	
	public function __set($name, $value){
		switch($name){
			case 'triggered':
				$this->_triggered[] = $value;
				break;
		}
	}
	
}