<?php

if($_SERVER["REMOTE_ADDR"] != '83.84.131.214'){exit;}

set_time_limit(300);

error_reporting(E_ALL);
ini_set('display_errors','On');

$start = microtime(true);

include('Autoloader.php');

$inputLayer = array(
	'type' => 'input',
	'parameters' => array('sizeX' => 4, 'sizeY' => 5)
);

$layer1 = array(
	'type' => '',
	'parameters' => array('members' => 30)
);

$outputLayer = array(
	'type' => 'output',
	'parameters' => array('members' => 10)
);

$layers = array($inputLayer, $layer1, $outputLayer);

$brain = Brain::instance($layers, array(1, 2, 3, 4, 5, 6, 7, 8, 9, 0));

$arr = array();
$arr[] = array('input' => array(
	0, 1, 1, 0,
	0, 0, 1, 0,
	0, 0, 1, 0,
	0, 0, 1, 0,
	0, 0, 1, 0
), 'answer' => 1);

$arr[] = array('input' => array(
	0, 0, 1, 0,
	0, 1, 1, 0,
	0, 0, 1, 0,
	0, 0, 1, 0,
	0, 0, 1, 0
), 'answer' => 1);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	0, 0, 0, 1,
	1, 1, 1, 1,
	1, 0, 0, 0,
	1, 1, 1, 1
), 'answer' => 2);

$arr[] = array('input' => array(
	1, 1, 1, 0,
	0, 0, 0, 1,
	0, 1, 1, 1,
	1, 0, 0, 0,
	1, 1, 1, 1
), 'answer' => 2);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	0, 0, 0, 1,
	0, 1, 1, 1,
	0, 0, 0, 1,
	1, 1, 1, 1
), 'answer' => 3);

$arr[] = array('input' => array(
	1, 1, 1, 0,
	0, 0, 0, 1,
	0, 1, 1, 1,
	0, 0, 0, 1,
	1, 1, 1, 0
), 'answer' => 3);

$arr[] = array('input' => array(
	1, 0, 0, 1,
	1, 0, 0, 1,
	1, 1, 1, 1,
	0, 0, 0, 1,
	0, 0, 0, 1
), 'answer' => 4);

$arr[] = array('input' => array(
	1, 0, 0, 1,
	1, 0, 0, 1,
	0, 1, 1, 1,
	0, 0, 1, 0,
	0, 0, 1, 0
), 'answer' => 4);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	1, 0, 0, 0,
	1, 1, 1, 1,
	0, 0, 0, 1,
	1, 1, 1, 1
), 'answer' => 5);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	1, 0, 0, 0,
	1, 1, 1, 0,
	0, 0, 0, 1,
	1, 1, 1, 0
), 'answer' => 5);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	1, 0, 0, 0,
	1, 1, 1, 1,
	1, 0, 0, 1,
	1, 1, 1, 1
), 'answer' => 6);

$arr[] = array('input' => array(
	0, 1, 1, 1,
	1, 0, 0, 0,
	1, 1, 1, 0,
	1, 0, 0, 1,
	0, 1, 1, 0
), 'answer' => 6);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	0, 0, 0, 1,
	0, 0, 0, 1,
	0, 0, 0, 1,
	0, 0, 0, 1
), 'answer' => 7);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	0, 0, 0, 1,
	0, 0, 1, 0,
	0, 0, 1, 0,
	0, 1, 0, 0
), 'answer' => 7);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	1, 0, 0, 1,
	1, 1, 1, 1,
	1, 0, 0, 1,
	1, 1, 1, 1
), 'answer' => 8);

$arr[] = array('input' => array(
	0, 1, 1, 0,
	1, 0, 0, 1,
	0, 1, 1, 0,
	1, 0, 0, 1,
	0, 1, 1, 0
), 'answer' => 8);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	1, 0, 0, 1,
	1, 1, 1, 1,
	0, 0, 0, 1,
	1, 1, 1, 1
), 'answer' => 9);

$arr[] = array('input' => array(
	0, 1, 1, 0,
	1, 0, 0, 1,
	0, 1, 1, 1,
	0, 0, 0, 1,
	1, 1, 1, 0
), 'answer' => 9);

$arr[] = array('input' => array(
	1, 1, 1, 1,
	1, 0, 0, 1,
	1, 0, 0, 1,
	1, 0, 0, 1,
	1, 1, 1, 1
), 'answer' => 0);

$arr[] = array('input' => array(
	0, 1, 1, 0,
	1, 0, 0, 1,
	1, 0, 0, 1,
	1, 0, 0, 1,
	0, 1, 1, 0
), 'answer' => 0);

shuffle($arr);

$brain->input($arr[0]['input'], $arr[0]['answer']);
$output = $brain->getOutput();
$brain->backPropagate($output);

$run = Memory::instance()->getLastRun();
$end = microtime(true);
echo json_encode(array('run' => $run, 'time' => $end - $start));
exit;

?>