<?php

header('Content-Type: application/json ; charset=utf-8');
header("Access-Control-Allow-Origin: *"); // or specify your domain instead of *

require_once '../connect/connectdb.php';  // adjust path if needed

try {
        
        $stmt = $pdo->query("SELECT * FROM m_items");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
       // return $users;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed'+ $e->getMessage()]);
    }
    exit();
function getitems(){
     try {
        
        $stmt = $pdo->query("SELECT * FROM m_items");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
       // return $users;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed'+ $e->getMessage()]);
    }
    exit();
}
getitems();
function additem(){
    $data = json_decode(file_get_contents('php://input'), true);
try {
    $stmt = $pdo->prepare("INSERT INTO m_items (item_name, measure,unit_price,description) VALUES (?,?,?,?)");
    $stmt->execute([$data['item_name'], $data['measure'], $data['unit_price'],$data['description']]);
    return json_encode(['message' => 'ITEM added successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    return json_encode(['message' => 'Database error' . $e->getMessage()]);
}
}
// $method = $_SERVER['REQUEST_METHOD'];

// if ($method !== 'GET' && $method !== 'POST') {
//     http_response_code(405);
//     echo json_encode(['error' => 'Method not allowed']);
//     exit();
// }

// if ($method === 'GET') {

//      if(isset($_GET['id'])){
//         try {
//             $stmt = $pdo->prepare("SELECT * FROM m_items WHERE item_id = ?");
//             $stmt->execute([$_GET['id']]);
//             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//             echo json_encode($result);
//         } catch (PDOException $e) {
//             http_response_code(500);
//             echo json_encode(['error' => 'Query failed']);
//         }
//         exit();
//     }

//     try {
//         $stmt = $pdo->query("SELECT * FROM m_items");
//         $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         echo json_encode($users);
//     } catch (PDOException $e) {
//         http_response_code(500);
//         echo json_encode(['error' => 'Query failed']);
//     }
//     exit();
// }


// if ($method === 'POST') {
//     // if (!isset($_POST['item_name']) || !isset($_POST['measure']) || !isset($_POST['unit_price'])) {
//     //     http_response_code(400);
//     //     echo json_encode(['error' => 'Bad request']);
//     //     exit();

//     // }
//     $data = json_decode(file_get_contents('php://input'), true);


// try {
//     $stmt = $pdo->prepare("INSERT INTO m_items (item_name, measure,unit_price,description) VALUES (?,?,?,?)");
//     $stmt->execute([$data['item_name'], $data['measure'], $data['unit_price'],$data['description']]);
//     echo json_encode(['message' => 'ITEM added successfully']);
// } catch (PDOException $e) {
//     http_response_code(500);
//     echo json_encode(['message' => 'Database error' . $e->getMessage()]);
// }

// }

?>
