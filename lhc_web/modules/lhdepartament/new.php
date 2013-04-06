<?php

$tpl = erLhcoreClassTemplate::getInstance( 'lhdepartament/new.tpl.php');
$Departament = new erLhcoreClassModelDepartament();
$currentUser = erLhcoreClassUser::instance();

if ( isset($_POST['Cancel_departament']) ) {
    erLhcoreClassModule::redirect('departament/departaments');
    exit;
}

if (isset($_POST['Save_departament']))
{
   $definition = array(
        'Name' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
   		'InstanceID' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'int'
        )
    );

    $form = new ezcInputForm( INPUT_POST, $definition );
    $Errors = array();

    if ( !$form->hasValidData( 'Name' ) || $form->Name == '' )
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('department/new','Please enter department name');
    }

    if ( $currentUser->hasAccessTo('lhdepartament','manage_instance') ) {
    	if ( $form->hasValidData( 'InstanceID' ) )
    	{
    		$Departament->instance_id = $form->InstanceID;
    	}
    } else {

    	$Departament->instance_id = erLhcoreClassInstance::getUserDefaultInstanceId($currentUser->getUserID());

    	if ($Departament->instance_id == 0){
    		$Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('department/new','Could not determine the instance');
    	}
    }

    if (count($Errors) == 0) {
        $Departament->name = $form->Name;
        erLhcoreClassDepartament::getSession()->save($Departament);
        erLhcoreClassModule::redirect('departament/departaments');
        exit ;
    }  else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->set('departament',$Departament);
$tpl->set('current_user',$currentUser);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
array('url' => erLhcoreClassDesign::baseurl('system/configuration'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/new','System configuration')),
array('url' => erLhcoreClassDesign::baseurl('departament/departaments'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/new','Departments')),
array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/new','New department')),
)

?>