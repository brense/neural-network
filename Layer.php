<?php

class Layer {
	
	protected $_type = 'default';
	protected $_members = array();
	
	public function __construct($parameters){
		if(isset($parameters['members'])){
			for($n = 0; $n < $parameters['members']; $n++){
				$this->_members[] = new Neuron(0, 0);
			}
		}
	}
	
	public function connect(Layer $layer){
		foreach($layer->members as $member){
			$member->synapses = count($this->_members);
		}
		foreach($this->_members as $member){
			$member->dendrites = count($layer->members);
			foreach($layer->members as $m){
				$member->connect($m);
			}
		}
	}
	
	public function __get($name){
		switch($name){
			case 'members':
				return $this->_members;
				break;
			case 'type':
				return $this->_type;
				break;
		}
	}
	
	public function backPropagate(Array $triggered, Array $desired, Array $wrong){
		$nextLayer = Brain::instance()->getNextLayer($this);
		
		if($nextLayer !== false){
			$nextDesired = array();
			$nextWrong = array();
			
			foreach($desired as $d){
				foreach($nextLayer->members as $m){
					if(in_array($m, $triggered)){
						// get the connection between $d and $m and strengthen it a little bit (it was already correct we want to reward that).
						$conn = $d->getConnection($m);
						Memory::instance()->reward($d, $conn);
					} else {
						$nextDesired[] = $m;
						
						// get the connection between $d and $m and strengthen it a lot because it was wrong and should trigger easier.
						$conn = $d->getConnection($m);
						Memory::instance()->increase($d, $conn);
					}
				}
			}
			
			foreach($wrong as $w){
				foreach($nextLayer->members as $m){
					if(in_array($m, $triggered)){
						$nextWrong[] = $m;
						
						// get the connection between $w and $m and weaken it a little bit.
						$conn = $w->getConnection($m);
						Memory::instance()->decrease($w, $conn);
					}
				}
			}
			
			$nextLayer->backPropagate($triggered, $nextDesired, $nextWrong);
		}
	}
	
}