<a href="<?php echo url_for('@homepage'); ?>" id="cancel">Cancel</a>

<h1>Invalid RFID</h1>
<p>The tag you swiped does not exist in the system.</p>

<?php include_component('home', 'timer', array('url' => url_for('@homepage'), 'timer' => 30)); ?>
