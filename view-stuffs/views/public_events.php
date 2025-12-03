<?php
// public_events.php - event details + registration form
?>
<?php if (!empty($errors)): ?>
  <div class="error">
    <?php foreach ($errors as $eitem) echo "<div>" . e($eitem) . "</div>"; ?>
  </div>
<?php endif; ?>

<h2><?= e($event['title']) ?></h2>
<div class="meta"><?= date('F j, Y, g:ia', strtotime($event['event_date'])) ?> — <?= e($event['location']) ?></div>
<p><?= nl2br(e($event['description'])) ?></p>

<hr>
<h3>Register for this event</h3>
<form method="post" action="index.php?page=client&action=register">
  <input type="hidden" name="event_id" value="<?= (int)$event['id'] ?>">
  <div class="form-row">
    <label for="name">Name</label>
    <input id="name" name="name" type="text" value="<?= e($_POST['name'] ?? '') ?>" required>
  </div>
  <div class="form-row">
    <label for="email">Email</label>
    <input id="email" name="email" type="email" value="<?= e($_POST['email'] ?? '') ?>" required>
  </div>
  <div class="form-row">
    <input type="submit" value="Register">
  </div>
</form>
