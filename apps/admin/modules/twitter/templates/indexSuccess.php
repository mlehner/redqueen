<?php if (isset($twitter)): ?>
<?php if ($twitter->account->verifyCredentials()): ?>
<p>Validated credentials! Ready to update your status...</p>
<?php else: ?>
<p>Credentials could not be validated! Something is wrong :(</p>
<?php endif; ?>
<?php else: ?>
<p><?php echo link_to('Authorize Twitter', 'twitter/auth'); ?></p>
<?php endif; ?>
