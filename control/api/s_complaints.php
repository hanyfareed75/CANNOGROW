<?php
header('Content-Type: application/json ; charset=utf-8');
require_once '..connect/connectdb.php';  // adjust path if needed

$method = $_SERVER['REQUEST_METHOD'];
// Open a file to log the data
$file = fopen("request_log.txt", "a");
fwrite($file, "Request at " . date("Y-m-d H:i:s") . "\n");

// Log the incoming data
fwrite($file, "REQUEST: " . print_r($_REQUEST, true) . "\n");

// If it's a POST request, log raw input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    fwrite($file, "POST Data: " . file_get_contents("php://input") . "\n");
}

// Close the file
fclose($file);
if ($method !== 'GET' && $method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

if ($method === 'GET') {
    try {
        $stmt = $pdo->query("SELECT * FROM s_complains");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed']);
    }
    exit();
}


if ($method === 'POST') {
    // if (!isset($_POST['item_name']) || !isset($_POST['measure']) || !isset($_POST['unit_price'])) {
    //     http_response_code(400);
    //     echo json_encode(['error' => 'Bad request']);
    //     exit();

    // }
    $data = json_decode(file_get_contents('php://input'), true);
try {
    $stmt = $pdo->prepare("INSERT INTO s_complains (comp_date,cust_id,category, complain,trans,status) VALUES (?,?,?,?,?)");
    $stmt->execute([$data['comp_date'],[$data['tran_date'], $data['item_id'], $data['qty'], $data['trans'], $data['notes']]);
    echo json_encode(['message' => 'Transaction added successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Database error' . $e->getMessage()]);
}

}

?>
