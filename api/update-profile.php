<?php
// Start session if needed
session_start();

// Simulate DB connection (replace with real connection)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'your_database_name';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// Get form values
$name  = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$city  = $_POST['city'];

// Optional: Handle avatar upload
$avatar_path = null;
if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["avatar"]["name"]);
    $target_file = $target_dir . time() . "_" . $file_name;

    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        $avatar_path = $target_file;
    }
}

// Simulate user ID (you should get this from the session)
$user_id = 1;

// Update user info
$sql = "UPDATE users SET name=?, email=?, phone=?, city=?";

if ($avatar_path) {
    $sql .= ", avatar=?";
}

$sql .= " WHERE id=?";

$stmt = $conn->prepare($sql);

if ($avatar_path) {
    $stmt->bind_param("ssssssi", $name, $email, $phone, $city, $avatar_path, $user_id);
} else {
    $stmt->bind_param("sssssi", $name, $email, $phone, $city, $user_id);
}

if ($stmt->execute()) {
    echo "✅ تم تحديث البيانات بنجاح!";
    // Optionally redirect: header("Location: profile.php");
} else {
    echo "❌ حدث خطأ أثناء التحديث: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
