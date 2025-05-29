<?php
require 'config.php';
requireAdmin();

$id = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

header('Location: admin_users.php');
exit();
?>
