<h1>Welcome <?php echo $username; ?>!</h1>

<p>The door is now open and will remain open for 5 seconds. Enter now.</p>

<?php include_component('home', 'timer', array('url' => url_for('@homepage'), 'timer' => 5)); ?>
