<?php
// public_confirm.php - shows confirmation after registration
?>
<div class="alert">
  Thank you, <strong><?= e($registered_name) ?></strong> — your registration for
  <strong><?= e($registered_event['title']) ?></strong> has been recorded.
</div>

<p>
  Event: <?= e($registered_event['title']) ?><br>
  Date: <?= date('F j, Y, g:ia', strtotime($registered_event['event_date'])) ?><br>
  Location: <?= e($registered_event['location']) ?>
</p>

<p><a href="index.php">Back to events</a></p>
