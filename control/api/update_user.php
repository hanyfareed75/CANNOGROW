<?php
require 'config.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $id       = intval($_POST['id']);
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $role     = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET username=?, email=?, role=? WHERE id=?");
    $stmt->bind_param("sssi",$username,$email,$role,$id);
    $stmt->execute();
}

header('Location: admin_users.php');
exit();
?>
