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

echo json_encode(Memory::instance()->getRuns());
exit;

?>