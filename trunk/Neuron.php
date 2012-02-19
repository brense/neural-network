<?php

class Neuron {
	
	protected $_id;
	protected $_dendrites = array();
	protected $_synapses = array();
	protected $_treshold = 0.8;
	protected $_weights = array();
	protected $_triggered = false;
	protected static $_count = 0;
	
	public function __construct(){
		self::$_count++;
		$this->_id = self::$_count;
	}
	
	public function addDendrite(Dendrite $dendrite){
		$this->_dendrites[] = $dendrite;		
		$dendrite->setNeuron($this);
		$this->_weights[$dendrite->id] = Memory::instance()->getWeights($dendrite);
	}
	
	public function addSynapse(Synapse $synapse){
		$this->_synapses[] = $synapse;
		$synapse->setNeuron($this);
	}
	
	public function connect(Neuron $neuron){
		$d = null;
		foreach($this->_dendrites as $dendrite){
			if(!$dendrite->connected()){
				$d = $dendrite;
				break;
			}
		}
		$s = null;
		foreach($neuron->synapses as $synapse){
			if(!$synapse->connected()){
				$s = $synapse;
				break;
			}
		}
		if(isset($d) && isset($s)){
			$d->setSynapse($s);
			$s->setDendrite($d);
		}
	}
	
	public function trigger(Dendrite $dendrite){
		if((float)$this->_weights[$dendrite->id] >= (float)$this->_treshold){
			$this->_triggered = true;
			Brain::instance()->triggered = $this;
			foreach($this->_synapses as $synapse){
				$synapse->trigger();
			}
		}
		if((float)$this->_weights[$dendrite->id] > 0){
			$this->_treshold -= (float)$this->_weights[$dendrite->id];
		}
	}
	
	public function getConnection(Neuron $neuron){
		foreach($this->_dendrites as $dendrite){
			if($dendrite->synapse->neuron === $neuron){
				return $dendrite;
			}
		}
	}
	
	public function __get($name){
		switch($name){
			case 'synapses':
				return $this->_synapses;
				break;
			case 'dendrites':
				return $this->_dendrites;
				break;
			case 'weights':
				return $this->_weights;
				break;
			case 'id':
				return $this->_id;
				break;
			case 'triggered':
				return $this->_triggered;
				break;
		}
	}
	
	public function __set($name, $value){
		switch($name){
			case 'synapses':
				$synapses = array();
				for($n = 0; $n < $value; $n++){
					$this->addSynapse(new Synapse());
				}
				break;
			case 'dendrites':
				$dendrites = array();
				for($n = 0; $n < $value; $n++){
					$this->addDendrite(new Dendrite());
				}
				break;
		}
	}
	
}