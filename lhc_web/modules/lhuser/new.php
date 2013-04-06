<?php

$tpl = erLhcoreClassTemplate::getInstance( 'lhuser/new.tpl.php');

$UserData = new erLhcoreClassModelUser();
$UserDepartaments = isset($_POST['UserDepartament']) ? $_POST['UserDepartament'] : array();

if (isset($_POST['Update_account']))
{
   $definition = array(
        'Password' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'Password1' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'Email' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'validate_email'
        ),
        'Name' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'Surname' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'Username' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
		'UserDisabled' => new ezcInputFormDefinitionElement(
				ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
		),
		'HideMyStatus' => new ezcInputFormDefinitionElement(
				ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
		),
   		'all_departments' => new ezcInputFormDefinitionElement(
				ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
		),
		'all_instances' => new ezcInputFormDefinitionElement(
				ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
		),
		'DefaultGroup' => new ezcInputFormDefinitionElement(
				ezcInputFormDefinitionElement::OPTIONAL, 'int',
				null,
				FILTER_REQUIRE_ARRAY
		)
    );

    $form = new ezcInputForm( INPUT_POST, $definition );
    $Errors = array();

    if ( !$form->hasValidData( 'Email' ) )
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Wrong email address');
    }

    if ( !$form->hasValidData( 'Name' ) || $form->Name == '' )
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Please enter name');
    }

    if ( !$form->hasValidData( 'Surname' ) || $form->Surname == '')
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Please enter surname');
    }

    if ( !$form->hasValidData( 'Username' ) || $form->Username == '')
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Please enter username');
    }

    if ( $form->hasValidData( 'Username' ) && $form->Username != '' && erLhcoreClassModelUser::userExists($form->Username) === true )
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','User exists');
    }

    if ( !$form->hasValidData( 'Password' ) || !$form->hasValidData( 'Password1' ) || $form->Password == '' || $form->Password1 == '' || $form->Password != $form->Password1    ) // check for optional field
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Passwords mismatch');
    }

    if ( $form->hasValidData( 'DefaultGroup' ) ) {
    	$UserData->user_groups_id = $form->DefaultGroup;
    } else {
    	$Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Please choose default user group');
    }

    if ( $form->hasValidData( 'UserDisabled' ) && $form->UserDisabled == true )
    {
    	$UserData->disabled = 1;
    } else {
    	$UserData->disabled = 0;
    }

    if ( $form->hasValidData( 'HideMyStatus' ) && $form->HideMyStatus == true )
    {
    	$UserData->hide_online = 1;
    } else {
    	$UserData->hide_online = 0;
    }

    if ( $form->hasValidData( 'all_instances' ) && $form->all_instances == true )
    {
    	$UserData->all_instances = 1;
    } else {
    	$UserData->all_instances = 0;
    }

    if ( $form->hasValidData( 'all_departments' ) && $form->all_departments == true )
    {
    	$UserData->all_departments = 1;
    } else {
    	$UserData->all_departments = 0;
    }

    if (count($Errors) == 0)
    {
        $UserData->setPassword($form->Password);
        $UserData->email   = $form->Email;
        $UserData->name    = $form->Name;
        $UserData->surname = $form->Surname;
        $UserData->username = $form->Username;

        erLhcoreClassUser::getSession()->save($UserData);


        erLhcoreClassUserDep::deleteUserDepartament(0, $UserData->id);

        if ($UserData->all_departments == 1) {
        	erLhcoreClassUserDep::addUserDepartament(0, $UserData->id, $UserData);
        }

        erLhcoreClassModelGroupUser::removeUserFromGroups($UserData->id);

        foreach ($UserData->user_groups_id as $group_id) {
        	$groupUser = new erLhcoreClassModelGroupUser();
        	$groupUser->group_id = $group_id;
        	$groupUser->user_id = $UserData->id;
        	$groupUser->saveThis();
        }

        erLhcoreClassModule::redirect('user/userlist');
        exit;

    }  else {

        if ( $form->hasValidData( 'Email' ) )
        {
            $UserData->email = $form->Email;
        }

        $UserData->name = $form->Name;
        $UserData->surname = $form->Surname;
        $UserData->username = $form->Username;

        $tpl->set('errors',$Errors);
    }
}


$tpl->set('user',$UserData);
$tpl->set('userdepartaments',$UserDepartaments);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
array('url' => erLhcoreClassDesign::baseurl('system/configuration'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','System configuration')),

array('url' => erLhcoreClassDesign::baseurl('user/userlist'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Users')),

array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','New user'))

)

?>