
<?php
require_once './config/database.php';

class StoreModel {
    private PDO $db;
    private $conn;
    public function __construct() {
        $this->db = (new Database())->connect();
    }

function getallStore(){
    try {
        
$stmt = $this->db->query("SELECT m_store.tran_id, m_store.tran_date,m_items.item_name,m_store.qty,m_store.trans,m_store.notes FROM m_store INNER JOIN m_items ON m_items.item_id=m_store.item_id ORDER BY m_store.tran_id ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        die(['error' => 'Query failed'+ $e->getMessage()]);
    }
    exit();

}
public function insertStore($tran_date, $item_id, $qty, $trans,$notes) {
    $stmt = $this->db->prepare("INSERT INTO m_store (tran_date, item_id, qty, trans, notes) VALUES (?,?,?,?,?)");
 
    return   $stmt->execute([$tran_date, $item_id, $qty, $trans,$notes]);
}

}
?>
