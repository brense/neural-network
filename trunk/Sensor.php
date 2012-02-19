<?php

class Sensor extends Neuron {
	
	private $_type;
	
	public function __construct($type){
		parent::__construct();
		$this->_type = $type;
	}
	
	public function trigger(){
		Brain::instance()->triggered = $this;
		foreach($this->_synapses as $synapse){
			$synapse->trigger();
		}
	}
	
	public function __get($name){
		switch($name){
			case 'synapses':
				return $this->_synapses;
				break;
			case 'type':
				return $this->_type;
				break;
		}
	}
	
}