<?php
// admin_registrations.php
?>
<h2>Registrations by Event</h2>

<?php if (empty($grouped)): ?>
  <p>No registrations yet.</p>
<?php else: ?>
  <?php foreach ($grouped as $event_id => $data): ?>
    <div style="border:1px solid #eef2fb; padding:12px; margin-bottom:12px; border-radius:8px;">
      <h3><?= e($data['event_title']) ?></h3>
      <div class="meta"><?= date('F j, Y, g:ia', strtotime($data['event_date'])) ?></div>

      <?php if (empty($data['registrations'])): ?>
        <p>No registrations for this event.</p>
      <?php else: ?>
        <table class="table">
          <thead><tr><th>Name</th><th>Email</th><th>Registered At</th></tr></thead>
          <tbody>
            <?php foreach ($data['registrations'] as $r): ?>
              <tr>
                <td><?= e($r['name']) ?></td>
                <td><?= e($r['email']) ?></td>
                <td><?= date('Y-m-d g:ia', strtotime($r['registered_at'])) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
