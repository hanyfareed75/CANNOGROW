
<?php
require_once './config/database.php';

class AccJournModel {
    private PDO $db;
    private $conn;
    public function __construct() {
        $this->db = (new Database())->connect();
    }

function get(){
    try {
        
$stmt = $this->db->query("SELECT * FROM acc_journal ORDER BY j_id DESC ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        die(['error' => 'Query failed'+ $e->getMessage()]);
    }
    exit();

}
public function store($date, $gl_id, $value, $notes) {
    $stmt = $this->db->prepare("INSERT INTO  acc_journal (date, gl_id, value, value, notes) VALUES (?,?,?,?,?)");
 
    return   $stmt->execute([$date, $gl_id, $value, $notes]);
}

}
?>
