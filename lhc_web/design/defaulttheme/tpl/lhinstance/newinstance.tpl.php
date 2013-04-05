<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/new','New instance');?></h1>

<?php if (isset($errors)) : ?>
	<?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
<?php endif; ?>

<form action="<?php echo erLhcoreClassDesign::baseurl('instance/newinstance')?>" method="post">

	 <?php include(erLhcoreClassDesign::designtpl('lhinstance/form.tpl.php'));?>

    <ul class="button-group radius">
    <li><input type="submit" class="small button" name="Save_instance" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/new','Save');?>"/></li>
	<li><input type="submit" class="small button" name="Cancel_instance" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/new','Cancel');?>"/></li>
	</ul>

</form>
