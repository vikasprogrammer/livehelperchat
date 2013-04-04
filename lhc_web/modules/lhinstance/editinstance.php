<?php

$tpl = erLhcoreClassTemplate::getInstance('lhinstance/editinstance.tpl.php');

$Departament = erLhcoreClassModelInstance::fetch((int)$Params['user_parameters']['instance_id']);

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
        )
    );

    $form = new ezcInputForm( INPUT_POST, $definition );
    $Errors = array();

    if ( !$form->hasValidData( 'Name' ) || $form->Name == '' )
    {
        $Errors[] =  erTranslationClassLhTranslation::getInstance()->getTranslation('departament/edit','Please enter departament name');
    }

    if ( $form->hasValidData( 'RemoteInstanceID' )  )
    {
    	$Departament->remote_instance_id = $form->RemoteInstanceID;
    }

    if (count($Errors) == 0)
    {
        $Departament->name = $form->Name;
        $Departament->saveThis();

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

$tpl->set('instance',$Departament);

$Result['content'] = $tpl->fetch();

$Result['path'] = array(
array('url' => erLhcoreClassDesign::baseurl('system/configuration'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','System configuration')),
array('url' => erLhcoreClassDesign::baseurl('departament/departaments'),'title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','departments')),
array('title' => erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Edit department').' - '.$Departament->name),);

?>