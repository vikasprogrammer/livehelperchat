<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lh_instance";
$def->class = "erLhcoreClassModelInstance";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['name'] = new ezcPersistentObjectProperty();
$def->properties['name']->columnName   = 'name';
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['domain'] = new ezcPersistentObjectProperty();
$def->properties['domain']->columnName   = 'domain';
$def->properties['domain']->propertyName = 'domain';
$def->properties['domain']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['email'] = new ezcPersistentObjectProperty();
$def->properties['email']->columnName   = 'email';
$def->properties['email']->propertyName = 'email';
$def->properties['email']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['remote_instance_id'] = new ezcPersistentObjectProperty();
$def->properties['remote_instance_id']->columnName   = 'remote_instance_id';
$def->properties['remote_instance_id']->propertyName = 'remote_instance_id';
$def->properties['remote_instance_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['status'] = new ezcPersistentObjectProperty();
$def->properties['status']->columnName   = 'status';
$def->properties['status']->propertyName = 'status';
$def->properties['status']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>