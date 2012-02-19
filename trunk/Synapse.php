<?php

class Synapse {
	
	private $_dendrite;
	private $_neuron;
	private $_triggered = false;
	
	public function __construct(){
		
	}
	
	public function setDendrite(Dendrite $dendrite){
		$this->_dendrite = $dendrite;
	}
	
	public function setNeuron(Neuron $neuron){
		$this->_neuron = $neuron;
	}
	
	public function connected(){
		if($this->_dendrite instanceof Dendrite){
			return true;
		} else {
			return false;
		}
	}
	
	public function trigger(){
		$this->_triggered = true;
		if($this->_dendrite instanceof Dendrite){
			$this->_dendrite->trigger();
		}
	}
	
	public function __get($name){
		switch($name){
			case 'dendrite':
				return $this->_dendrite;
				break;
			case 'neuron':
				return $this->_neuron;
				break;
		}
	}
	
	public function output(){
		if($this->_triggered){
			return '1';
		} else {
			return '0';
		}
	}
	
}