<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Logged user');?> - <?php echo $user->name,' ',$user->surname?></h1>

<dl class="tabs">
  <dd <?php if ($tab == '') : ?>class="active"<?php endif;?>><a href="#simple1"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Account data');?></a></dd>
  <dd <?php if ($tab == 'tab_settings') : ?>class="active"<?php endif;?>><a href="#simple3"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Other');?></a></dd>
</dl>

<?php if (isset($errors)) : ?>
	<?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<?php if (isset($account_updated) && $account_updated == 'done') : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Account updated'); ?>
	<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<?php endif; ?>

<ul class="tabs-content">
  <li <?php if ($tab == '') : ?>class="active"<?php endif;?> id="simple1Tab">

	<div class="explain"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Do not enter password unless you want to change it');?></div>
	<br />
	<form action="<?php echo erLhcoreClassDesign::baseurl('user/account')?>" method="post" autocomplete="off">

	    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Username');?></label>
	    <input type="text" <?php if (!$current_user->hasAccessTo('lhuser','change_login_data')) : ?>disabled="disabled"<?php endif;?> placeholder="Your username" name="Username" value="<?php echo htmlspecialchars($user->username);?>" />

	    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Password');?></label>
	    <input type="password" <?php if (!$current_user->hasAccessTo('lhuser','change_login_data')) : ?>disabled="disabled"<?php endif;?> placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Enter new password');?>" name="Password" value=""/>

	    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Repeat password');?></label>
	    <input type="password" <?php if (!$current_user->hasAccessTo('lhuser','change_login_data')) : ?>disabled="disabled"<?php endif;?> placeholder="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Repeat new password');?>" name="Password1" value=""/>

	    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Email');?></label>
	    <input type="text" value="<?php echo $user->email;?>" name="Email" placeholder="Your email address" id="email" class="required email valid">

	    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Name');?></label>
	    <input type="text" name="Name" value="<?php echo htmlspecialchars($user->name);?>"/>

	    <label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Surname');?></label>
	    <input type="text" name="Surname" value="<?php echo htmlspecialchars($user->surname);?>"/>

	    <ul class="button-group radius">
	    	<li><input type="submit" name="Update" class="small button" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Update');?>"></li>
	    	<li><a href="<?php echo erLhcoreClassDesign::baseurl()?>" class="small button"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Return');?></a></li>
	    </ul>
	</form>
  </li>
  <li id="simple3Tab" <?php if ($tab == 'tab_settings') : ?>class="active"<?php endif;?>>
  <h5><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Visible lists');?></h5>
  <form action="<?php echo erLhcoreClassDesign::baseurl('user/account')?>" method="post">
	<label><input type="checkbox" name="pendingTabEnabled" value="1" <?php erLhcoreClassModelUserSetting::getSetting('enable_pending_list',1) == 1 ? print 'checked="checked"' : '' ?> /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Pending chats tab enabled');?></label>
	<label><input type="checkbox" name="activeTabEnabled" value="1" <?php erLhcoreClassModelUserSetting::getSetting('enable_active_list',1) == 1 ? print 'checked="checked"' : '' ?> /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Active chats tab enabled');?></label>
	<label><input type="checkbox" name="unreadTabEnabled" value="1" <?php erLhcoreClassModelUserSetting::getSetting('enable_unread_list',1) == 1 ? print 'checked="checked"' : '' ?> /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Unread chats tab enabled');?></label>
	<label><input type="checkbox" name="closedTabEnabled" value="1" <?php erLhcoreClassModelUserSetting::getSetting('enable_close_list',0) == 1 ? print 'checked="checked"' : '' ?> /> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Closed chats tab enabled');?></label>
	<input type="submit" class="small button" name="UpdateTabsSettings_account" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Update');?>"/>
  </form>
  </li>
</ul>



