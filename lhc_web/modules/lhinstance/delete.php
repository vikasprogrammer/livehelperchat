<?php

$instance = erLhcoreClassModelInstance::fetch($Params['user_parameters']['instance_id']);
$instance->removeThis();

// Delete user assigned departaments
// $q = ezcDbInstance::get()->createDeleteQuery();
// $q->deleteFrom( 'lh_departament' )->where( $q->expr->eq( 'id', $Params['user_parameters']['departament_id'] ) );
// $stmt = $q->prepare();
// $stmt->execute();

erLhcoreClassModule::redirect('instance/listinstances');
exit;

?>