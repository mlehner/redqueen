<table>
<thead>
<tr>
<th>Full Name</th>
<th>Nickname</th>
<th>Username</th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php foreach($members as $member): ?>
<tr>
<td><?php echo $member->getFullName(); ?></td>
<td><?php echo $member->getNickname(); ?></td>
<td><?php echo $member->getUsername(); ?></td>
<td></td>
</tr>
<tr>
<td colspan="4">
<table>
<?php foreach($member->getTags() as $tag): ?>
<tr>
<td><?php echo $tag->getRFID(); ?></td>
<td><?php echo join(', ', $tag->getDoors()); ?></td>
</tr>
<?php endforeach; ?>
</table>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
