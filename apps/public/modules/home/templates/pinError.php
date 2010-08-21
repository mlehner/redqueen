<?php use_helper('Form'); ?>
<a href="<?php echo url_for('@homepage'); ?>" id="cancel">Cancel</a>

<h1>Enter PIN</h1>
<p>Enter the PIN for your Tag.</p>

<?php if ($error): ?>
<p>The PIN you entered was not valid for this tag.</p>
<?php endif; ?>

<?php echo form_tag('@pin', array('method'=>'post')); ?>
<?php echo input_password_tag('pin', $sf_request->getParameter('pin')); ?>

<?php echo submit_tag('Submit'); ?>
<?php echo '</form>'; ?>

<?php include_component('home', 'timer', array('url' => url_for('@homepage'), 'timer' => 120)); ?>
<?php include_component('home', 'keypad'); ?>
