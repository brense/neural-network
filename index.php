<pre>
<?php
include('Autoloader.php');

/*
$inputLayer = array(
	'type' => 'input',
	'parameters' => array('sizeX' => 29, 'sizeY' => 29)
);

$layer1 = array(
	'type' => 'convolutional',
	'parameters' => array('maps' => 6, 'sizeX' => 13, 'sizeY' => 13)
);

$layer2 = array(
	'type' => 'convolutional',
	'parameters' => array('maps' => 50, 'sizeX' => 5, 'sizeY' => 5)
);

$layer3 = array(
	'type' => '',
	'parameters' => array('members' => 100)
);

$outputLayer = array(
	'type' => 'output',
	'parameters' => array('members' => 10)
);

$layers = array($inputLayer, $layer1, $layer2, $layer3, $outputLayer);
*/

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
$brain->showStructure();

?>
</pre>