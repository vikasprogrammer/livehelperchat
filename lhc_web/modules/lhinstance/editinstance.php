<?php

$tpl = erLhcoreClassTemplate::getInstance('lhinstance/editinstance.tpl.php');

$Instance = erLhcoreClassModelInstance::fetch((int)$Params['user_parameters']['instance_id']);

if ( isset($_POST['Cancel_instance']) ) {
    erLhcoreClassModule::redirect('instance/listinstances');
    exit;
}

if (isset($_POST['Update_instance']) || isset($_POST['Save_instance'])  )
{
   $definition = array(
        'Name' => new ezcInputFormDefinitionElement(
            ezcInputFormDefinitionElement::OPTIONAL, 'unsafe_raw'
        ),
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
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('departament/edit','Please enter instance name');
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

        if (isset($_POST['Save_instance'])) {
            erLhcoreClassModule::redirect('instance/listinstances');
            exit;
        } else {
            $tpl->set('updated',true);
        }

    }  else {
        $tpl->set('errors',$Errors);
    }
}

$tpl->set('instance',$Instance);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
array('url' => erLhcoreClassDesign::baseurl('system/configuration'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','System configuration')),
array('url' => erLhcoreClassDesign::baseurl('instance/listinstances'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Instances')),
array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('instance/edit','Edit instance').' - '.$Instance->name),);

?>