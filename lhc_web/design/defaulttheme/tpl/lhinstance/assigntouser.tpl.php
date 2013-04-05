<?php if (isset($assigned) && $assigned == true) : ?>
<?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/groupassignuser','Instance was assigned to user!'); ?>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<script>
setTimeout(function(){
    parent.document.location = '<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $user->id?>#simpleDepartmetns2';
    parent.document.location.reload();
},2000);
</script>
<?php endif; ?>

<h2>Assign instance</h2>

<form action="<?php echo erLhcoreClassDesign::baseurl('instance/assigntouser')?>/<?php echo $user->id?>" method="post">
<?php if ($pages->items_total > 0) : ?>
	<table cellpadding="0" cellspacing="0" width="100%">
	<thead>
	    <tr>
	        <th class="one">ID</th>
	        <th class="eleven"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/assigntouser','Title');?></th>
	    </tr>
	</thead>
	<?php foreach ($items as $item) : ?>
	    <tr>
	        <td><input type="checkbox" name="InstanceID[]" value="<?php echo $item->id?>"></td>
	        <td><?php echo htmlspecialchars($item->name)?></td>
	    </tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

<?php if (isset($pages)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
<?php endif;?>
<input type="submit" class="small button" name="AssignInstance" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/groupassignuser','Assign');?>" />
</form>