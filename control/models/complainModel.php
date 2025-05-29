
<?php
require_once './config/database.php';

class ComplainModel {
    private PDO $db;
    private $conn;
    public function __construct() {
        $this->db = (new Database())->connect();
    }

function get(){
    try {
        
$stmt = $this->db->query("SELECT * FROM s_complains ORDER BY compl_id DESC ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        die(['error' => 'Query failed'+ $e->getMessage()]);
    }
    exit();

}
public function store($comp_date, $cust_id, $category, $complain,$status) {
    $stmt = $this->db->prepare("INSERT INTO s_complains (comp_date, cust_id, category, complain,  status) VALUES (?,?,?,?,?)");
 
    return   $stmt->execute([$comp_date, $cust_id, $category, $complain,$status]);
}

}
?>
