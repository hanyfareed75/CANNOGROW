<?php
require 'config.php';
requireAdmin();

// جلب جميع المستخدمين
$result = $conn->query("SELECT id, username, email, role, created_at FROM users");
?>
<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>إدارة المستخدمين</title>
</head>
<body>
  <h2>لوحة تحكم المدير – إدارة المستخدمين</h2>
  <a href="register.php">+ إضافة مستخدم جديد</a>
  <table border="1" cellpadding="5" cellspacing="0">
    <tr>
      <th>#</th><th>اسم</th><th>بريد</th><th>صلاحية</th><th>تاريخ الإنشاء</th><th>إجراءات</th>
    </tr>
    <?php while($u = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $u['id'] ?></td>
      <td><?= htmlspecialchars($u['username']) ?></td>
      <td><?= htmlspecialchars($u['email']) ?></td>
      <td><?= $u['role'] ?></td>
      <td><?= $u['created_at'] ?></td>
      <td>
        <a href="edit_user.php?id=<?= $u['id'] ?>">تعديل</a> |
        <a href="delete_user.php?id=<?= $u['id'] ?>"
           onclick="return confirm('هل تريد الحذف فعلاً؟')">حذف</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
