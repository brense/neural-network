<?php

class Dendrite {
	
	private $_id;
	private $_synapse;
	private $_neuron;
	private $_triggered = false;
	private static $_count = 0;
	
	public function __construct(){
		self::$_count++;
		$this->_id = self::$_count;
	}
	
	public function setSynapse(Synapse $synapse){
		$this->_synapse = $synapse;
	}
	
	public function setNeuron(Neuron $neuron){
		$this->_neuron = $neuron;
	}
	
	public function connected(){
		if($this->_synapse instanceof Synapse){
			return true;
		} else {
			return false;
		}
	}
	
	public function trigger(){
		$this->_triggered = true;
		$this->_neuron->trigger($this);
	}
	
	public function __get($name){
		switch($name){
			case 'synapse':
				return $this->_synapse;
				break;
			case 'neuron':
				return $this->_neuron;
				break;
			case 'id':
				return $this->_id;
				break;
		}
	}
	
}