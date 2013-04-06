<?php

$departament = erLhcoreClassDepartament::getSession()->load( 'erLhcoreClassModelDepartament', $Params['user_parameters']['departament_id']);

$currentUser = erLhcoreClassUser::instance();
$UserData = $currentUser->getUserData();

if ( erLhcoreClassModelInstanceUser::isInstanceOperator($departament->instance_id, $UserData) ) {

	erLhcoreClassDepartament::getSession()->delete($departament);

	// Delete user assigned departaments
	$q = ezcDbInstance::get()->createDeleteQuery();
	$q->deleteFrom( 'lh_departament' )->where( $q->expr->eq( 'id', $Params['user_parameters']['departament_id'] ) );
	$stmt = $q->prepare();
	$stmt->execute();
}

erLhcoreClassModule::redirect('departament/departaments');
exit;

?>