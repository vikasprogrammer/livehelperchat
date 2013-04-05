<?php

$tpl = erLhcoreClassTemplate::getInstance( 'lhinstance/newinstance.tpl.php');
$Instance = new erLhcoreClassModelInstance();

if ( isset($_POST['Cancel_instance']) ) {
    erLhcoreClassModule::redirect('instance/listinstances');
    exit;
}

if (isset($_POST['Save_instance']))
{
   $definition = array(
        'Name' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ) ,
        'RemoteInstanceID' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'int'
        ),
   		'InstanceActive' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'boolean'
        )
    );

    $form = new ezcInputForm( INPUT_POST, $definition );
    $Errors = array();

    if ( !$form->hasValidData( 'Name' ) || $form->Name == '' )
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('department/new','Please enter instance name');
    }

    if ( $form->hasValidData( 'RemoteInstanceID' )  )
    {
    	$Instance->remote_instance_id = $form->RemoteInstanceID;
    }

    if ( $form->hasValidData( 'InstanceActive' ) &&  $form->InstanceActive == true ) {
    	$Instance->status = 1;
    } else {
    	$Instance->status = 0;
    }

    if (count($Errors) == 0)
    {
        $Instance->name = $form->Name;
        $Instance->saveThis();
        erLhcoreClassModule::redirect('instance/listinstances');
        exit ;

    }  else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->set('instance',$Instance);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
array('url' => erLhcoreClassDesign::baseurl('system/configuration'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/new','System configuration')),
array('url' => erLhcoreClassDesign::baseurl('instance/listinstances'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/new','Instances')),
array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/new','New instance')),
)

?>