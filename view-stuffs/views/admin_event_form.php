<?php
// admin_event_form.php
$editing = !empty($event) && !empty($event['id']);
$form_title = $editing ? "Edit Event" : "Create Event";
?>
<h2><?= e($form_title) ?></h2>

<?php if (!empty($errors)): ?>
  <div class="error">
    <?php foreach ($errors as $err) echo "<div>" . e($err) . "</div>"; ?>
  </div>
<?php endif; ?>

<form method="post" action="index.php?page=admin&action=save_event">
  <input type="hidden" name="id" value="<?= (int)($event['id'] ?? 0) ?>">
  <div class="form-row">
    <label for="title">Title</label>
    <input id="title" name="title" type="text" value="<?= e($event['title'] ?? '') ?>" required>
  </div>
  <div class="form-row">
    <label for="event_date">Date and Time</label>
    <?php
      // For datetime-local, value must be YYYY-MM-DDTHH:MM (without seconds)
      $dt_val = '';
      if (!empty($event['event_date'])) {
          $dt = new DateTime($event['event_date']);
          $dt_val = $dt->format('Y-m-d\TH:i');
      }
    ?>
    <input id="event_date" name="event_date" type="datetime-local" value="<?= e($dt_val) ?>" required>
  </div>
  <div class="form-row">
    <label for="location">Location</label>
    <input id="location" name="location" type="text" value="<?= e($event['location'] ?? '') ?>" required>
  </div>
  <div class="form-row">
    <label for="description">Description</label>
    <textarea id="description" name="description" required><?= e($event['description'] ?? '') ?></textarea>
  </div>
  <div class="form-row">
    <input type="submit" value="<?= $editing ? 'Save Changes' : 'Create Event' ?>">
    <a href="index.php?page=admin&action=dashboard" class="button-secondary small" style="margin-left:8px">Cancel</a>
  </div>
</form>
