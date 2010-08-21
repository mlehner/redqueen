<h1>Welcome</h1>
<p>To begin, swipe your Tag at any time, or select from one of the actions below.</p>

<a href="<?php echo url_for('@login') ?>">Login</a>
<a href="<?php echo url_for('@register') ?>">Register a Tag</a>

<?php if (false): ?>
<p>You are at door: <?php echo $sf_user->getDoor(); ?></p>
<a href="<?php echo url_for('@door') ?>">Change Door</a>
<?php endif; ?>
