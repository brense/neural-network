<?php

class OutputLayer extends Layer {
	
	protected $_type = 'output';
	
	public function __construct($parameters){
		parent::__construct($parameters);
		foreach($this->_members as $member){
			$member->synapses = 1;
		}
	}
	
}