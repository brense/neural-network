<?php

class Memory {
	
	private static $_instance;
	private $_db;
	private $_brain;
	private static $_adjustments = 0;
	private $_run;
	
	private function __construct($brainId){
		$this->_db = mysql_connect('localhost', 'root', '');
		mysql_select_db('neuron');
		$this->_brain = $brainId;
		
		$query = "SELECT * FROM runs ORDER BY run DESC LIMIT 0,1";
		$result = mysql_query($query);
		$run = 0;
		while($row = mysql_fetch_array($result)){
			if(isset($row['run'])){
				$run = $row['run'];
			}
		}
		$this->_run = $run + 1;
	}
	
	public static function instance($brainId = null){
		if(empty(self::$_instance)){
			self::$_instance = new self($brainId);
		}
		return self::$_instance;
	}
	
	public function backPropagate($answer, $input, $output){
		$query = "INSERT INTO runs (answer, input, output, adjustments) VALUES ('" . $answer . "', '" . serialize($input) . "', '" . $output . "', '" . self::$_adjustments . "')";
		mysql_query($query);
	}
	
	public function reward(Neuron $neuron, Dendrite $dendrite){
		$history = $this->getHistory($dendrite);
		if($neuron->weights[$dendrite->id] < 0.5){
			if($history['mean'] > 0){
				// we're pretty sure the weight is moving in the right direction
				$this->adjust($dendrite, 0.005);
			} else {
				// we're unsure if the weight is moving in the right direction
				$this->adjust($dendrite, 0.001);
			}
		}
	}
	
	public function increase(Neuron $neuron, Dendrite $dendrite){
		$history = $this->getHistory($dendrite);
		if($neuron->weights[$dendrite->id] < 0.5){
			if($history['mean'] > 0){
				// we're pretty sure the weight is moving in the right direction
				$this->adjust($dendrite, 0.02);
			} else {
				// we're unsure if the weight is moving in the right direction
				$this->adjust($dendrite, 0.005);
			}
		}
	}
	
	public function decrease(Neuron $neuron, Dendrite $dendrite){
		$history = $this->getHistory($dendrite);
		if($neuron->weights[$dendrite->id] > 0.01){
			if($history['mean'] < 0){
				// we're pretty sure the weight is moving in the right direction
				$this->adjust($dendrite, -0.02);
			} else {
				// we're unsure if the weight is moving in the right direction
				$this->adjust($dendrite, -0.005);
			}
		}
	}
	
	private function adjust(Dendrite $dendrite, $adjustment){
		if($adjustment != 0){
			self::$_adjustments++;
			// insert in history table
			$query = "INSERT INTO history (brain, dendrite, run, adjustment) VALUES ('" . $this->_brain . "', '" . $dendrite->id . "', '" . $this->_run . "', '" . $adjustment . "')";
			mysql_query($query);
			// update in memory table
			$query = "UPDATE memory SET weight = weight + " . $adjustment . " WHERE brain = '" . $this->_brain . "' AND dendrite = '" . $dendrite->id . "'";
			mysql_query($query);
		}
	}
	
	private function getHistory(Dendrite $dendrite){
		$history = array();
		$total = (float)0;
		$query = "SELECT * FROM history WHERE brain = '" . $this->_brain . "' AND dendrite = '" . $dendrite->id . "'";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			if(isset($row['adjustment'])){
				$total += (float)$row['adjustment'];
			}
			$history[] = $row;
		}
		
		if(count($history) > 0){
			return array('mean' => $total / count($history), 'history' => $history);
		} else {
			return array('mean' => 0, 'history' => $history);
		}
	}
	
	public function getWeights(Dendrite $dendrite){
		$weights = array();
		$query = "SELECT * FROM memory WHERE brain = '" . $this->_brain . "' AND dendrite = '" . $dendrite->id . "'";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			$weights[$dendrite->id] = $row['weight'];
		}
		
		if(!isset($weights[$dendrite->id])){
			$query = "INSERT INTO memory (brain, dendrite, weight) VALUES ('" . $this->_brain . "', '" . $dendrite->id . "', '" . 0.06 . "')";
			mysql_query($query);
			$weights[$dendrite->id] = 0.06;
		}
		
		return $weights[$dendrite->id];
	}
	
	public function getLastRun(){
		$query = "SELECT * FROM runs ORDER BY run DESC LIMIT 0,1";
		$result = mysql_query($query);
		$run = array();
		while($row = mysql_fetch_array($result)){
			foreach($row as $k => $v){
				if(is_numeric($k)){
					unset($row[$k]);
				}
			}
			if(isset($row['run'])){
				$run = $row;
			}
		}
		return $run;
	}
	
	public function getRuns(){
		$runs = array();
		$query = "SELECT * FROM runs ORDER BY run ASC";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result)){
			foreach($row as $k => $v){
				if(is_numeric($k)){
					unset($row[$k]);
				}
			}
			if(isset($row['run'])){
				$runs[] = $row;
			}
		}
		return $runs;
	}
	
}