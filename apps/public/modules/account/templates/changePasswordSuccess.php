<?php use_helper('Form'); ?>
<h1>Change Password</h1>
<?php if ($sf_user->hasFlash('error')): ?>
<p class="error"><?php echo $sf_user->getFlash('error'); ?></p>
<?php endif; ?>
<?php if ($sf_user->hasFlash('notice')): ?>
<p class="notice"><?php echo $sf_user->getFlash('notice'); ?></p>
<?php endif; ?>
<?php echo $form->renderFormTag(url_for('account/change-password')); ?>
<ul>
<?php echo $form; ?>
</ul>
<?php echo submit_tag('Do it!'); ?>
</form>
