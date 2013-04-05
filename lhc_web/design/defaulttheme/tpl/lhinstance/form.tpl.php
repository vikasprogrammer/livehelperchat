<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/edit','Name');?>*</label>
<input type="text" name="Name"  value="<?php echo htmlspecialchars($instance->name);?>" />

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/edit','Remote instance ID');?></label>
<input type="text" name="RemoteInstanceID"  value="<?php echo htmlspecialchars($instance->remote_instance_id);?>" />

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('instance/edit','Active');?></label>
<input type="checkbox" name="InstanceActive" value="1" <?php ($instance->status == 1) ? print 'checked="checked"' : '' ?>  />