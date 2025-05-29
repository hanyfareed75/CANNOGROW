<?php
require 'config.php';
requireAdmin();

$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($username,$email,$role);
if (!$stmt->fetch()) {
  die("المستخدم غير موجود");
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar">
<head><meta charset="UTF-8"><title>تعديل مستخدم</title></head>
<body>
  <h2>تعديل بيانات المستخدم</h2>
  <form method="POST" action="update_user.php">
    <input type="hidden" name="id" value="<?= $id ?>">
    <label>الاسم:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required><br>
    <label>البريد:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br>
    <label>الصلاحية:</label>
    <select name="role">
      <option value="user"  <?= $role=='user'?'selected':'' ?>>مستخدم</option>
      <option value="admin" <?= $role=='admin'?'selected':'' ?>>مدير</option>
    </select><br>
    <button type="submit">حفظ التغييرات</button>
  </form>
</body>
</html>
