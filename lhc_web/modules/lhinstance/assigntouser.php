<?php

$tpl = erLhcoreClassTemplate::getInstance('lhinstance/assigntouser.tpl.php');
$user = erLhcoreClassModelUser::fetch($Params['user_parameters']['user_id']);

if (isset($_POST['AssignInstance'])) {
	$definition = array (
			'InstanceID' => new ezcInputFormDefinitionElement(
					ezcInputFormDefinitionElement::OPTIONAL, 'int',
					null,
					FILTER_REQUIRE_ARRAY
			)
	);

	$form = new ezcInputForm( INPUT_POST, $definition );
	$Errors = array();
	$instancesArray = array();

	if ( $form->hasValidData( 'InstanceID' ) ) {
		$instancesArray = $form->InstanceID;
	} else {
		$Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Please choose instance');
	}

	if (count($Errors) == 0) {

		erLhcoreClassModelInstanceUser::removeInstancesFromUser($user->id);

		foreach ($instancesArray as $instance_id) {
			$instanceUser = new erLhcoreClassModelInstanceUser();
			$instanceUser->instance_id = $instance_id;
			$instanceUser->user_id = $user->id;
			$instanceUser->saveThis();
		}

		$tpl->set('assigned',true);

	}  else {
        $tpl->set('errors',$Errors);
    }
}

$pages = new lhPaginator();
$pages->serverURL = erLhcoreClassDesign::baseurl('instance/assigntouser').'/'.$user->id;
$pages->items_total = erLhcoreClassInstance::getCount();
$pages->setItemsPerPage(20);
$pages->paginate();

$items = array();
if ($pages->items_total > 0) {
	$items = erLhcoreClassInstance::getList(array('offset' => $pages->low, 'limit' => $pages->items_per_page,'sort' => 'id ASC'));
}

$tpl->set('items',$items);
$tpl->set('pages',$pages);
$tpl->set('user',$user);

$Result['content'] = $tpl->fetch();
$Result['pagelayout'] = 'popup';

?>