<?php

$tpl = erLhcoreClassTemplate::getInstance('lhdepartament/edit.tpl.php');

$Departament = erLhcoreClassDepartament::getSession()->load( 'erLhcoreClassModelDepartament', (int)$Params['user_parameters']['departament_id'] );
$currentUser = erLhcoreClassUser::instance();
$UserData = $currentUser->getUserData();


if ( !erLhcoreClassModelInstanceUser::isInstanceOperator($Departament->instance_id, $UserData) ) {
	erLhcoreClassModule::redirect('departament/departaments');
	exit;
}



if ( isset($_POST['Cancel_departament']) ) {
    erLhcoreClassModule::redirect('departament/departaments');
    exit;
}

if (isset($_POST['Update_departament']) || isset($_POST['Save_departament'])  )
{
   $definition = array(
        'Name' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
        'InstanceID' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'int'
		),
        'Email' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'validate_email'
        )
    );

    $form = new ezcInputForm( INPUT_POST, $definition );
    $Errors = array();

    if ( !$form->hasValidData( 'Name' ) || $form->Name == '' )
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('departament/edit','Please enter departament name');
    }

    if ( $form->hasValidData( 'Email' ) ) {
    	$Departament->email = $form->Email;
    } else {
    	$Departament->email = '';
    }

    if ( $currentUser->hasAccessTo('lhdepartament','manage_instance') ) {
	    if ( $form->hasValidData( 'InstanceID' ) )
	    {
	    	$Departament->instance_id = $form->InstanceID;
	    }
    }

    if (count($Errors) == 0)
    {
        $Departament->name = $form->Name;

        erLhcoreClassDepartament::getSession()->update($Departament);

        if (isset($_POST['Save_departament'])) {
            erLhcoreClassModule::redirect('departament/departaments');
            exit;
        } else {
            $tpl->set('updated',true);
        }

    }  else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->set('departament',$Departament);
$tpl->set('current_user',$currentUser);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
array('url' => erLhcoreClassDesign::baseurl('system/configuration'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','System configuration')),
array('url' => erLhcoreClassDesign::baseurl('departament/departaments'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','departments')),
array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Edit department').' - '.$Departament->name),);

?>