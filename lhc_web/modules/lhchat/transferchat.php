<?php

$tpl = erLhcoreClassTemplate::getInstance('lhchat/transferchat.tpl.php');
$chat = erLhcoreClassChat::getSession()->load( 'erLhcoreClassModelChat', $Params['user_parameters']['chat_id']);

if ( erLhcoreClassChat::hasAccessToRead($chat) )
{
	$validTabs = array('department','instance','instancedepartment');
	$tab = in_array((string)$Params['user_parameters_unordered']['tab'], $validTabs) ? (string)$Params['user_parameters_unordered']['tab'] : '';
	$tpl->set('tab',$tab);

	if (isset($_POST['TransferToDepartment'])) {

		if (isset($_POST['DepartamentID'.$chat->id])) {
			$currentUser = erLhcoreClassUser::instance();
			$destinationDepartmentID = $_POST['DepartamentID'.$chat->id];

			if (erLhcoreClassUserDep::canMoveToDepartment($destinationDepartmentID,$currentUser->getUserID())){
				$Transfer = new erLhcoreClassModelTransfer();
				$Transfer->chat_id = $chat->id;
				$Transfer->dep_id = $destinationDepartmentID;

				// Original department id
				$Transfer->from_dep_id = $chat->dep_id;

				// Assign correct department
				$departmenttDestination = erLhcoreClassModelDepartament::fetch($Transfer->dep_id);
				$Transfer->instance_id = $departmenttDestination->instance_id;

				// User which is transfering
				$Transfer->transfer_user_id = $currentUser->getUserID();

				$Transfer->saveThis();

				$tpl->set('chat_transfered',true);
			} else {
				$tpl->set('errors',array('Permission denied to move to selected department'));
			}
		} else {
			$tpl->set('errors',array('Please choose department'));
		}
	}

	if (isset($_POST['TransferToUser'])) {

		if (isset($_POST['TransferTo'.$chat->id])) {
			$currentUser = erLhcoreClassUser::instance();
			$destinationDepartmentID = $_POST['TransferTo'.$chat->id];

				$Transfer = new erLhcoreClassModelTransfer();
				$Transfer->chat_id = $chat->id;
				$Transfer->transfer_to_user_id = $destinationDepartmentID;

				// Original department id
				$Transfer->from_dep_id = $chat->dep_id;

				// User which is transfering
				$Transfer->transfer_user_id = $currentUser->getUserID();

				$Transfer->saveThis();

				$tpl->set('chat_transfered',true);
		} else {
			$tpl->set('errors',array('Please choose department'));
		}
	}


	$currentUser = erLhcoreClassUser::instance();

	if ($tab == 'department') {
		$limitation = erLhcoreClassChat::getInstanceLimitation('lh_departament',$currentUser->getUserID());
		$filterArray = array();

		// Does not have any assigned department
		if ($limitation === false) {
			$filterArray['filter']['instance_id'] = -1;
		} elseif ($limitation !== true) {
			$filterArray['customfilter'][] = $limitation;
		}

		$pages = new lhPaginator();
		$pages->serverURL = erLhcoreClassDesign::baseurl('chat/transferchat').'/'.$chat->id.'/(tab)/department';
		$pages->items_total = erLhcoreClassModelDepartament::getCount($filterArray);
		$pages->setItemsPerPage(10);
		$pages->paginate();

		$items = array();
		if ($pages->items_total > 0) {
			$items = erLhcoreClassModelDepartament::getList(array_merge($filterArray,array('offset' => $pages->low, 'limit' => $pages->items_per_page,'sort' => 'id ASC')));
		}

		$tpl->set('items',$items);
		$tpl->set('pages',$pages);
	} elseif ($tab == 'instance') {

		$pages = new lhPaginator();
		$pages->serverURL = erLhcoreClassDesign::baseurl('chat/transferchat').'/'.$chat->id.'/(tab)/instance';
		$pages->items_total = erLhcoreClassInstance::getCount();
		$pages->setItemsPerPage(10);
		$pages->paginate();

		$items = array();
		if ($pages->items_total > 0) {
		    $items = erLhcoreClassInstance::getList(array('offset' => $pages->low, 'limit' => $pages->items_per_page,'sort' => 'id ASC'));
		}

		$tpl->set('items',$items);
		$tpl->set('pages',$pages);
	}

	$tpl->set('chat',$chat);
	$currentUser = erLhcoreClassUser::instance();
	$tpl->set('user_id',$currentUser->getUserID());
	$tpl->set('current_user',$currentUser);

	$Result['content'] = $tpl->fetch();
	$Result['pagelayout'] = 'popup';
	$Result['adjust_size_colorbox'] = true;

}
?>