<?php
// public_event.php - lists upcoming events
?>
<h2>Upcoming Events</h2>

<div class="event-list">
  <?php if (empty($events)): ?>
    <p>No upcoming events at the moment.</p>
  <?php else: ?>
    <?php foreach ($events as $ev): ?>
      <div class="event">
        <h3><?= e($ev['title']) ?></h3>
        <div class="meta"><?= date('F j, Y, g:ia', strtotime($ev['event_date'])) ?> — <?= e($ev['location']) ?></div>
        <p><?= e(mb_strimwidth($ev['description'], 0, 260, '...')) ?></p>
        <div style="margin-top:8px">
          <a class="small" href="index.php?page=client&action=detail&id=<?= (int)$ev['id'] ?>">View details</a>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
