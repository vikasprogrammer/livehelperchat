<?php if (isset($assigned) && $assigned == true) : ?>
<?php $msg = erTranslationClassLhTranslation::getInstance()->getTranslation('user/groupassignuser','Instance was assigned to user!'); ?>
<?php include(erLhcoreClassDesign::designtpl('lhkernel/alert_success.tpl.php'));?>
<script>
setTimeout(function(){
    parent.document.location = '<?php echo erLhcoreClassDesign::baseurl('user/edit')?>/<?php echo $user->id?>';
    parent.document.location.reload();
},2000);
</script>
<?php endif; ?>

<h2>Assign department</h2>

<form action="<?php echo erLhcoreClassDesign::baseurl('departament/assigntouser')?>/<?php echo $user->id?>" method="post">
<?php if ($pages->items_total > 0) : ?>
	<table cellpadding="0" cellspacing="0" width="100%">
	<thead>
	    <tr>
	        <th class="one">ID</th>
	        <th class="five"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/assigntouser','Title');?></th>
	        <th class="five"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/assigntouser','Instance');?></th>
	    </tr>
	</thead>
	<?php foreach ($items as $item) : ?>
	    <tr>
	        <td><input type="checkbox" name="DepartmentID[]" value="<?php echo $item->id?>"></td>
	        <td><?php echo htmlspecialchars($item->name)?></td>
	        <td><?php echo htmlspecialchars($item->instance)?></td>
	    </tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

<?php if (isset($pages)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
<?php endif;?>

<input type="submit" class="small button" name="AssignDepartment" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('user/groupassignuser','Assign department');?>" />
</form>