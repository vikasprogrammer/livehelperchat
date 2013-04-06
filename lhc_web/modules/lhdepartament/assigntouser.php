<?php

$tpl = erLhcoreClassTemplate::getInstance('lhdepartament/assigntouser.tpl.php');
$user = erLhcoreClassModelUser::fetch($Params['user_parameters']['user_id']);

if (isset($_POST['AssignDepartment'])) {
	$definition = array (
			'DepartmentID' => new ezcInputFormDefinitionElement(
					ezcInputFormDefinitionElement::OPTIONAL, 'int',
					null,
					FILTER_REQUIRE_ARRAY
			)
	);

	$form = new ezcInputForm( INPUT_POST, $definition );
	$Errors = array();
	$instancesArray = array();

	if ( $form->hasValidData( 'DepartmentID' ) ) {
		$instancesArray = $form->DepartmentID;
	} else {
		$Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Please choose department');
	}

	if (count($Errors) == 0) {

		foreach ($instancesArray as $instance_id) {
			erLhcoreClassUserDep::deleteUserDepartament($instance_id,$user->id);

			$instanceUser = new erLhcoreClassModelUserDep();
			$instanceUser->dep_id = $instance_id;
			$instanceUser->user_id = $user->id;
			$instanceUser->hide_online = $user->hide_online;
			$instanceUser->saveThis();
		}

		$tpl->set('assigned',true);

	}  else {
        $tpl->set('errors',$Errors);
    }
}

$limitation = erLhcoreClassChat::getInstanceLimitation('lh_departament',$user->id);
$filterArray = array();

// Does not have any assigned department
if ($limitation === false) {
	$filterArray['filter']['instance_id'] = -1;
} elseif ($limitation !== true) {
	$filterArray['customfilter'][] = $limitation;
}

$pages = new lhPaginator();
$pages->serverURL = erLhcoreClassDesign::baseurl('department/assigntouser').'/'.$user->id;
$pages->items_total = erLhcoreClassModelDepartament::getCount($filterArray);
$pages->setItemsPerPage(20);
$pages->paginate();

$items = array();
if ($pages->items_total > 0) {
	$items = erLhcoreClassModelDepartament::getList(array_merge($filterArray,array('offset' => $pages->low, 'limit' => $pages->items_per_page,'sort' => 'id ASC')));
}

$tpl->set('items',$items);
$tpl->set('pages',$pages);
$tpl->set('user',$user);

$Result['content'] = $tpl->fetch();
$Result['pagelayout'] = 'popup';

?>