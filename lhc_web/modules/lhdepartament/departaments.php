<?php

$tpl = erLhcoreClassTemplate::getInstance( 'lhdepartament/departaments.tpl.php');

$currentUser = erLhcoreClassUser::instance();

$limitation = erLhcoreClassChat::getInstanceLimitation('lh_departament',$currentUser->getUserID());
$filterArray = array();

// Does not have any assigned department
if ($limitation === false) {
	$filterArray['filter']['instance_id'] = -1;
} elseif ($limitation !== true) {
	$filterArray['customfilter'][] = $limitation;
}

$pages = new lhPaginator();
$pages->serverURL = erLhcoreClassDesign::baseurl('departament/departaments');
$pages->items_total = erLhcoreClassModelDepartament::getCount($filterArray);
$pages->setItemsPerPage(20);
$pages->paginate();

$items = array();
if ($pages->items_total > 0) {
    $items = erLhcoreClassModelDepartament::getList(array_merge($filterArray,array('offset' => $pages->low, 'limit' => $pages->items_per_page,'sort' => 'id ASC')));
}

$tpl->set('items',$items);
$tpl->set('pages',$pages);

$Result['content'] = $tpl->fetch();
$Result['path'] = array(
array('url' => erLhcoreClassDesign::baseurl('system/configuration'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/departments','System configuration')),
array('url' => erLhcoreClassDesign::baseurl('department/departments'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/departments','Departments')))

?>