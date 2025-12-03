<?php
// admin_login.php
?>
<h2>Admin Login</h2>

<?php if (!empty($error)): ?>
  <div class="error"><?= e($error) ?></div>
<?php endif; ?>

<form method="post" action="index.php?page=admin&action=login">
  <div class="form-row">
    <label for="username">Username</label>
    <input id="username" name="username" type="text" value="<?= e($_POST['username'] ?? '') ?>" required>
  </div>
  <div class="form-row">
    <label for="password">Password</label>
    <input id="password" name="password" type="password" required>
  </div>
  <div class="form-row">
    <input type="submit" value="Login">
  </div>
</form>
