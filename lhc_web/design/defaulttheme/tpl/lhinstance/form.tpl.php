<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Name');?>*</label>
<input type="text" name="Name"  value="<?php echo htmlspecialchars($instance->name);?>" />

<label><?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('department/edit','Remote instance ID');?></label>
<input type="text" name="RemoteInstanceID"  value="<?php echo htmlspecialchars($instance->remote_instance_id);?>" />