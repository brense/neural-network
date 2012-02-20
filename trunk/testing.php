<?php

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

$brain->input($arr[0]['input']);
echo json_encode(array('output' => $brain->getOutput(), 'answer' => $arr[0]['answer']));

exit;

?>