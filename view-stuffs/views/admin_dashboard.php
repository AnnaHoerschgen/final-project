<?php
// admin_dashboard.php
?>
<h2>Admin Dashboard</h2>

<p><a href="index.php?page=admin&action=event_form" class="small">+ Add New Event</a>
   <a href="index.php?page=admin&action=registrations" class="small button-secondary">View Registrations</a>
</p>

<table class="table">
  <thead>
    <tr>
      <th>Title</th>
      <th>Date</th>
      <th>Location</th>
      <th>Description</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($events as $ev): ?>
      <tr>
        <td><?= e($ev['title']) ?></td>
        <td><?= date('Y-m-d g:ia', strtotime($ev['event_date'])) ?></td>
        <td><?= e($ev['location']) ?></td>
        <td><?= e(mb_strimwidth($ev['description'], 0, 80, '...')) ?></td>
        <td class="actions">
          <a class="small" href="index.php?page=admin&action=event_form&id=<?= (int)$ev['id'] ?>">Edit</a>
          <a class="small" href="index.php?page=admin&action=delete_event&id=<?= (int)$ev['id'] ?>" onclick="return confirm('Delete this event?')">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
