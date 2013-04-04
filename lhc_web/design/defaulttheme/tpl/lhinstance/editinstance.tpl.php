<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Edit instance');?> - <?php echo htmlspecialchars($instance->name)?></h1>

<?php if (isset($errors)) : ?>
	<?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<?php if (isset($updated)) : $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/account','Updated'); ?>
	<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<?php endif; ?>

<form action="<?php echo erLhcoreClassDesign::baseurl('instance/editinstance')?>/<?php echo $instance->id?>" method="post">

    <?php include(erLhcoreClassDesign::designtpl('lhinstance/form.tpl.php'));?>

	<ul class="button-group radius">
      <li><input type="submit" class="small button" name="Save_instance" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Save');?>"/></li>
      <li><input type="submit" class="small button" name="Update_instance" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Update');?>"/></li>
      <li><input type="submit" class="small button" name="Cancel_instance" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Cancel');?>"/></li>
    </ul>

</form>
