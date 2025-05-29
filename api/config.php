<?php
session_start();

// اتصال قاعدة البيانات
$conn = new mysqli('localhost','root','','finance_db');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// دوال التحقق من الصلاحيات
function isAdmin() {
    return (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');
}

function requireAdmin() {
    if (!isAdmin()) {
        header('Location: login.php');
        exit();
    }
}

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
}
?>
