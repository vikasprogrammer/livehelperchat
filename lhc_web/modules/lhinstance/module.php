<?php

$Module = array( "name" => "Instance configuration");

$ViewList['listinstances'] = array(
    'script' => 'listinstances.php',
    'params' => array(),
    'functions' => array( 'manageinstances' )
);

$ViewList['newinstance'] = array(
    'script' => 'newinstance.php',
    'params' => array(),
    'functions' => array( 'manageinstances' )
);

$ViewList['editinstance'] = array(
		'script' => 'editinstance.php',
		'params' => array('instance_id'),
		'functions' => array( 'manageinstances' )
);

$ViewList['delete'] = array(
		'script' => 'delete.php',
		'params' => array('instance_id'),
		'functions' => array( 'delete' )
);

$FunctionList['manageinstances'] = array('explain' =>'Allow manage instances');

?>