<?php

class ConvolutionalLayer extends Layer {
	
	protected $_type = 'convolutional';
	protected $_maps = array();
	
	public function __construct($parameters){
		if(isset($parameters['maps']) && isset($parameters['sizeX']) && isset($parameters['sizeY'])){
			for($i = 0; $i < $parameters['maps']; $i++){
				for($n = 0; $n < ($parameters['sizeX'] * $parameters['sizeY']); $n++){
					$neuron = new Neuron(0, 0);
					$this->_maps[$i][$n] = $neuron;
					$this->_members[] = $neuron;
				}
			}
		}
	}
	
}