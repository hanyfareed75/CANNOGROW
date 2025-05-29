<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $fileName = basename($_FILES['file']['name']);
        $uploadFilePath = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
            echo json_encode(['success' => true, 'message' => 'File uploaded successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded or an error occurred.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
