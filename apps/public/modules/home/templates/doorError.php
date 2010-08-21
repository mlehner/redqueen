<?php use_helper('Form'); ?>
<a href="<?php echo url_for('@homepage'); ?>" id="cancel">Cancel</a>

<h1>Select Door</h1>
<p>You must pick a door to continue.</p>

<?php echo form_tag('@homepage', array('method'=>'post')); ?>
<?php echo select_tag('door', options_for_select($doors, $sf_user->getDoor())) ?>
<?php echo submit_tag('Submit'); ?>
<?php echo '</form>'; ?>

<?php include_component('home', 'timer', array('url' => url_for('@homepage'), 'timer' => 30)); ?>
