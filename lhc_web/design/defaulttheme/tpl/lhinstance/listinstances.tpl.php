<h1><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/instance','Instances');?></h1>

<table class="twelve" cellpadding="0" cellspacing="0">
<thead>
<tr>
    <th width="1%">ID</th>
    <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/instance','Name');?></th>
    <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/instance','Remote instance ID');?></th>
    <th><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/instance','Active');?></th>
    <th width="1%">&nbsp;</th>
    <th width="1%">&nbsp;</th>
</tr>
</thead>
<?php foreach ($items as $departament) : ?>
    <tr>
        <td><?php echo $departament->id?></td>
        <td><?php echo htmlspecialchars($departament->name)?></td>
        <td><?php echo htmlspecialchars($departament->remote_instance_id)?></td>
        <td><?php if ($departament->status == 1) : ?>Active<?php else : ?>Inactive<?php endif;?></td>
        <td nowrap><a class="tiny button round" href="<?php echo erLhcoreClassDesign::baseurl('instance/editinstance')?>/<?php echo $departament->id?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/instance','Edit instance');?></a></td>
        <td nowrap><a onclick="return confirm('<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('kernel/message','Are you sure?');?>')" class="tiny alert button round" href="<?php echo erLhcoreClassDesign::baseurl('instance/delete')?>/<?php echo $departament->id?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/instance','Delete instance');?></a></td>
    </tr>
<?php endforeach; ?>
</table>

<?php if (isset($pages)) : ?>
    <?php include(erLhcoreClassDesign::designtpl('lhkernel/paginator.tpl.php')); ?>
<?php endif;?>

<a class="small button" href="<?php echo erLhcoreClassDesign::baseurl('instance/newinstance')?>"><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/instance','New instance');?></a>
