<br>

<dl class="tabs w700">
    <dd <?php if ($tab == '') : ?>class="active"<?php endif;?>><a href="<?php echo erLhcoreClassDesign::baseurl('chat/transferchat')?>/<?php echo $chat->id?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Transfer to user');?></a></dd>
    <dd <?php if ($tab == 'instancedepartment') : ?>class="active"<?php endif;?>><a href="<?php echo erLhcoreClassDesign::baseurl('chat/transferchat')?>/<?php echo $chat->id?>/(tab)/instancedepartment"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Transfer to instance department');?></a></dd>

	<?php
	$canMakeGlobalTransfer = $current_user->hasAccessTo('lhchat','transfer_global');
	if ($canMakeGlobalTransfer == true) : ?>
    	<dd <?php if ($tab == 'department') : ?>class="active"<?php endif;?>><a href="<?php echo erLhcoreClassDesign::baseurl('chat/transferchat')?>/<?php echo $chat->id?>/(tab)/department"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Transfer to department');?></a></dd>
    	<dd <?php if ($tab == 'instance') : ?>class="active"<?php endif;?>><a href="<?php echo erLhcoreClassDesign::baseurl('chat/transferchat')?>/<?php echo $chat->id?>/(tab)/instance"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Transfer to instance');?></a></dd>
    <?php endif;?>
</dl>

<div id="transfer-block-<?php echo $chat->id?>"></div>

<?php if (isset($chat_transfered)) : ?>
		<?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Chat was transfered'); ?>
		<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>

		<script>
		setTimeout(function(){
		    parent.$.fn.colorbox.close();
		},2000);
		</script>

<?php endif; ?>

<?php if (isset($errors)) : ?>
		<?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<form action="" method="post">
<?php if ($tab == 'instance' && $canMakeGlobalTransfer == true) : ?>

<?php foreach ($items as $instance) :  ?>
        <h6>Instance - <?php echo htmlspecialchars($instance->name) ?></h6>
        <?php foreach ($instance->departments as $departament) : ?>
       		<label><input type="radio" name="DepartamentID<?php echo $chat->id?>" value="<?php echo $departament->id?>" /> <?php echo htmlspecialchars($departament->name)?> </label>
        <?php endforeach;?>
        <hr>
<?php endforeach; ?>

<?php if (isset($pages)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
<?php endif;?>

<br>
<input type="submit" name="TransferToDepartment" class="small button" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Transfer');?>" />

<?php elseif ($tab == 'department' && $canMakeGlobalTransfer == true) : ?>
		<h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Departments');?></h4>

  		<?php foreach ($items as $departament) : ?>
	        <label><input type="radio" <?php if ($departament->id == $chat->dep_id) : ?>disabled="disabled"<?php endif;?> name="DepartamentID<?php echo $chat->id?>" value="<?php echo $departament->id?>" /> <?php echo htmlspecialchars($departament->name)?></label>
	    <?php endforeach; ?>

	    <?php if (isset($pages)) : ?>
	    	<br>
		    <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
		<?php endif;?>

		<br>
		<input type="submit" name="TransferToDepartment" class="small button" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Transfer');?>" />

<?php elseif ($tab == 'instancedepartment') : ?>
		<h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','General departments');?></h4>
		<?php foreach (erLhcoreClassModelDepartament::getList(array('limit' => 5000, 'filter' => array('instance_id' => 0))) as $departament) : ?>
			<label><input type="radio" name="DepartamentID<?php echo $chat->id?>" value="<?php echo $departament->id?>"<?php in_array($departament->id,$userDepartaments) ? print 'checked="checked"' : '';?>/> <?php echo htmlspecialchars($departament->name)?></label>
		<?php endforeach;?>
		<hr>

		<h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Instance departments');?></h4>
  		<?php foreach (erLhcoreClassModelDepartament::getList(array('limit' => 5000, 'filter' => array('instance_id' => $chat->original_instance_id))) as $departament) :
  		if ($departament->id !== $chat->dep_id) : ?>
	        <label><input type="radio" name="DepartamentID<?php echo $chat->id?>" value="<?php echo $departament->id?>"<?php in_array($departament->id,$userDepartaments) ? print 'checked="checked"' : '';?>/> <?php echo htmlspecialchars($departament->name)?></label>
	    <?php endif; endforeach; ?>
		<br>
		<input type="submit" name="TransferToDepartment" class="small button" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Transfer');?>" />
<?php else : ?>
		<h4><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Logged users');?></h4>

  		<p><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Transfer chat to one of your departments users');?></p>

  		<?php foreach (erLhcoreClassChat::getOnlineUsers(array($user_id)) as $key => $user) : ?>
		    <label><input type="radio" name="TransferTo<?php echo $chat->id?>" value="<?php echo $user['id']?>" <?php echo $key == 0 ? 'checked="checked"' : ''?>> <?php echo htmlspecialchars($user['name'])?> <?php echo htmlspecialchars($user['surname'])?></label>
		<?php endforeach; ?>

		<br>
		<input type="submit" name="TransferToUser" class="small button" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/transferchat','Transfer');?>" />
<?php endif; ?>
</form>
<br>
<br>