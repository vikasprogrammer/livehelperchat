<?php

$Module = array( "name" => "Departments configuration");

$ViewList = array();

$ViewList['departaments'] = array(
    'script' => 'departaments.php',
    'params' => array(),
    'functions' => array( 'list' )
);

$ViewList['new'] = array(
    'script' => 'new.php',
    'params' => array(),
    'functions' => array( 'create' )
);

$ViewList['edit'] = array(
    'script' => 'edit.php',
    'params' => array('departament_id'),
    'functions' => array( 'edit' )
);

$ViewList['delete'] = array(
    'script' => 'delete.php',
    'params' => array('departament_id'),
    'functions' => array( 'delete' )
);

$ViewList['assigntouser'] = array(
		'script' => 'assigntouser.php',
		'params' => array('user_id'),
		'functions' => array( 'edit' )
);

$FunctionList['list'] = array('explain' => 'Access to list departments');
$FunctionList['manage_instance'] = array('explain' => 'Allow user to manage departments at instance level');
$FunctionList['create'] = array('explain' => 'Permission to create a new department');
$FunctionList['edit'] = array('explain' => 'Permission to edit department');
$FunctionList['delete'] = array('explain' => 'Permission to delete department');
$FunctionList['selfedit'] = array('explain' => 'Allow user to choose his departments');

?>