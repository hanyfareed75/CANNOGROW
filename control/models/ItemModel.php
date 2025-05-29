
<?php
namespace App\Models;


class ItemModel {
    private PDO $db;
   
    private $conn;
    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        $this->db = (new Database())->connect();
    }

function getallitems(){
    try {
        
$stmt = $this->db->query("SELECT * FROM m_items ORDER BY item_id DESC ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        die(['error' => 'Query failed'+ $e->getMessage()]);
    }
    exit();

}

function getselected(){
    try {
        
$stmt = $this->db->query("SELECT item_id,item_name FROM m_items ORDER BY item_id DESC ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        die(['error' => 'Query failed'+ $e->getMessage()]);
    }
    exit();

}
public function insertItem($item_name, $measure, $description) {
    $stmt = $this->db->prepare("INSERT INTO m_items (item_name, measure,description) VALUES (?,?,?)");
 
    return   $stmt->execute([$item_name, $measure, $description]);
}

}
?>


// <?php
// class UserModel {
//     private $conn;

//     public function __construct($db) {
//         $this->conn = $db;
//     }

//     public function insertUser($name, $email) {
//         $query = "INSERT INTO users (name, email) VALUES (:name, :email)";
//         $stmt = $this->conn->prepare($query);
//         return $stmt->execute([':name' => $name, ':email' => $email]);
//     }
// }








// ?>
