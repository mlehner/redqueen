<?php use_helper('Form'); ?>
<a href="<?php echo url_for('@homepage'); ?>" id="cancel">Cancel</a>

<h1>Enter Username and Password</h1>
<p>Enter your username and password.</p>

<?php if ($error): ?>
<p>The username and password you entered were not valid.</p>
<?php endif; ?>

<?php echo form_tag('@login', array('method'=>'post')); ?>
<?php echo label_for('username', 'Username:') ?>
<?php echo input_tag('username', $sf_request->getParameter('username')); ?>
<?php echo label_for('password', 'Password:') ?>
<?php echo input_password_tag('password'); ?>

<?php echo submit_tag('Submit'); ?>
<?php echo '</form>'; ?>

<?php include_component('home', 'timer', array('url' => url_for('@homepage'), 'timer' => 120)); ?>
<?php include_component('home', 'keyboard'); ?>
