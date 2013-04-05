<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','User edit');?> - <?php echo $user->name,' ',$user->surname?></h1>

<?php if (isset($errors)) : ?>
		<?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<?php if (isset($updated)) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Account updated'); ?>
	<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<?php endif; ?>

<div class="explain"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Do not enter password unless you want to change it');?></div>
<br />

<form action="<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $user->id?>" method="post" autocomplete="off">

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Username');?></label>
<input class="inputfield" type="text" name="Username" value="<?php echo htmlspecialchars($user->username);?>" />

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Password');?></label>
<input type="password" class="inputfield" name="Password" value=""/>

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Repeat password');?></label>
<input type="password" class="inputfield" name="Password1" value=""/>

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','E-mail');?></label>
<input type="text" class="inputfield" name="Email" value="<?php echo $user->email;?>"/>

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Name');?></label>
<input type="text" class="inputfield" name="Name" value="<?php echo htmlspecialchars($user->name);?>"/>

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Surname');?></label>
<input type="text" class="inputfield" name="Surname" value="<?php echo htmlspecialchars($user->surname);?>"/>

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','User group')?></label>
<?php echo erLhcoreClassRenderHelper::renderCombobox( array (
                    'input_name'     => 'DefaultGroup[]',
                    'selected_id'    => $user->user_groups_id,
					'multiple' 		 => true,
                    'list_function'  => 'erLhcoreClassModelGroup::getList'
            )); ?>

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Disabled')?>&nbsp;<input type="checkbox" value="on" name="UserDisabled" <?php echo $user->disabled == 1 ? 'checked="checked"' : '' ?> /></label>

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','Do not show user status as online')?>&nbsp;<input type="checkbox" value="on" name="HideMyStatus" <?php echo $user->hide_online == 1 ? 'checked="checked"' : '' ?> /></label>

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','All departments')?>&nbsp;<input type="checkbox" value="on" name="all_departments" <?php echo $user->all_departments == 1 ? 'checked="checked"' : '' ?> /></label>

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/new','All instances')?>&nbsp;<input type="checkbox" value="on" name="all_instances" <?php echo $user->all_instances == 1 ? 'checked="checked"' : '' ?> /></label>

<ul class="button-group radius">
<li><input type="submit" class="small button" name="Save_account" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Save');?>"/></li>
<li><input type="submit" class="small button" name="Update_account" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Update');?>"/></li>
<li><input type="submit" class="small button" name="Cancel_account" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Cancel');?>"/></li>
</ul>

</form>

<hr>

<dl class="tabs">
    <dd class="active"><a href="#simpleDepartmetns1" >Departments</a></dd>
    <dd><a href="#simpleDepartmetns2">Instances</a></dd>
</dl>

<ul class="tabs-content">
  <li id="simpleDepartmetns1Tab" class="active">
  		<h5><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Assigned departments');?></h5>

		<?php if (isset($account_updated_departaments) && $account_updated_departaments == 'done') : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Selected departments were removed'); ?>
			<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
		<?php endif; ?>

		<form action="<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $user->id?>" method="post">
		    <?php foreach (erLhcoreClassModelUserDep::getList(array('filter' => array('user_id' => $user->id))) as $departament) : ?>
		        <label><input type="checkbox" name="UserDepartament[]" value="<?php echo $departament->id?>" checked="checked"/><?php echo htmlspecialchars($departament->department)?> (<?php echo htmlspecialchars($departament->instance)?>)</label>
		    <?php endforeach; ?>

		    <ul class="button-group radius">
				<li><input type="submit" class="small button" name="RemoveSelectedDepartments" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Remove selected');?>"/></li>
				<li><a href="#" class="small button" onclick="return $.colorbox({'iframe':true,height:'500px',width:'500px', href:'<?php echo erLhcoreClassDesign::baseurl('department/assigntouser')?>/<?php echo $user->id?>'});"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Assign department');?></a></li>
			</ul>

		</form>

  </li>
  <li id="simpleDepartmetns2Tab">
		<h5><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Assigned instances');?></h5>

		<?php if (isset($account_updated_instances) && $account_updated_instances == 'done') : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Removed selected instances from user'); ?>
			<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
		<?php endif; ?>

		<form action="<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $user->id?>" method="post">

		    <?php $userInstances = erLhcoreClassInstance::getList(array('filter' => array('user_id' => $user->id)),'erLhcoreClassModelInstanceUser','lh_instance_user'); ?>

		    <?php foreach ($userInstances as $userInstance) : ?>
		    	<label><input type="checkbox" name="UserInstances[]" value="<?php echo $userInstance->instance_id?>" checked="checked"/><?php echo htmlspecialchars($userInstance->instance)?></label>
		    <?php endforeach;?>

		    <ul class="button-group radius">
				<li><input type="submit" class="small button" name="RemoveSelectedInstance" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Remove selected');?>"/></li>
				<li><a href="#" class="small button" onclick="return $.colorbox({'iframe':true,height:'500px',width:'500px', href:'<?php echo erLhcoreClassDesign::baseurl('instance/assigntouser')?>/<?php echo $user->id?>'});"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/edit','Assign instance');?></a></li>
			</ul>

		</form>

  </li>
</ul>





