<a href="<?php echo url_for('@homepage'); ?>" id="cancel">Cancel</a>

<h1>Register Tag</h1>
<p>To register your tag, swipe your Tag at any time.</p>

<?php include_component('home', 'timer', array('url' => url_for('@homepage'), 'timer' => 30)); ?>