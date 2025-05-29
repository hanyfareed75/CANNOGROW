
<?php
require_once __DIR__ . '/../config/database.php';

class ProductModel {
    private PDO $db;
    private $conn;
    public function __construct() {
        $this->db = (new Database())->connect();
    }

function getallProducts(){
    try {
        
$stmt = $this->db->query("SELECT * FROM s_product ORDER BY product_id DESC ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       
        die('Error: Query failed. ' . $e->getMessage());

    }
    exit();

}

function getselected(){
    try {
        
$stmt = $this->db->query("SELECT product_id,name_eng FROM s_product ORDER BY product_id DESC ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        die($errors);
    }
    exit();

}
public function getbyid($id){
    $stmt = $this->db->prepare("SELECT * FROM s_product WHERE product_id=?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function store($name_eng, $name_ar, $unit_price, $description_ar){ {
    $stmt = $this->db->prepare("INSERT INTO s_product ( name_eng, name_ar, unit_price, description_ar) VALUES (?,?,?,?)");
 
    return   $stmt->execute([$name_eng, $name_ar, $unit_price, $description_ar]);
}
}

}
?>
