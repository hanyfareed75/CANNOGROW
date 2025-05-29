<?php
require 'config.php';
requireLogin();

$id = $_SESSION['user_id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    // تحديث الاسم والبريد
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $stmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE id=?");
    $stmt->bind_param("ssi",$username,$email,$id);
    $stmt->execute();

    // تغيير كلمة المرور إذا وُضعت
    if (!empty($_POST['new_password'])) {
        $new = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        $stmt2 = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt2->bind_param("si",$new,$id);
        $stmt2->execute();
    }
    $msg = 'تم التحديث بنجاح!';
}

// جلب البيانات الحالية
$stmt = $conn->prepare("SELECT username,email FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($username,$email);
$stmt->fetch();
?>
<!DOCTYPE html>
<html lang="ar">
<head><meta charset="UTF-8"><title>الملف الشخصي</title></head>
<body>
  <h2>ملفي الشخصي</h2>
  <?php if ($msg): ?><p style="color:green;"><?= $msg ?></p><?php endif; ?>
  <form method="POST" action="">
    <label>الاسم:</label>
    <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" required><br>
    <label>البريد:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br>
    <label>كلمة المرور الجديدة (اختياري):</label>
    <input type="password" name="new_password"><br>
    <button type="submit">تحديث</button>
  </form>
</body>
</html>
