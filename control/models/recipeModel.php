<?php
class RecipeModel {
     private PDO $db;
    private $conn;
    public function __construct() {
         
         require_once __DIR__ . '/../config/database.php';
        $this->db = (new Database())->connect();
    }

function get(){
    try {
    //     $sql = "SELECT m_items.measure,m_recipe.rec_id,s_product.name_eng ,m_items.item_name ,m_recipe.rec_value , m_recipe.notes FROM `m_recipe` \n"

    // . "INNER JOIN s_product ON s_product.product_id=m_recipe.product_id\n"

    // . "INNER JOIN m_items ON m_recipe.item_id=m_items.item_id";

$sql = "SELECT j_product_item.rec_id,s_product.name_eng,m_items.item_name,j_product_item.qty,j_product_item.notes FROM `j_product_item` \n"

    . "INNER JOIN m_items ON j_product_item.item_id=m_items.item_id \n"

    . "INNER JOIN s_product ON j_product_item.product_id=s_product.product_id";

$stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        die(['error' => 'Query failed'+ $e->getMessage()]);
    }
    exit();

}

function getMeasure($id){
    //$sql="SELECT m_recipe.rec_id,m_items.item_id,m_items.measure FROM `m_recipe` INNER JOIN m_items ON m_recipe.item_id=m_items.item_id where m_items.item_id = ?";
    try{
    $sql="SELECT measure,item_id FROM `m_items` where m_items.item_id = ?";
    $stmt=$this->db->prepare($sql);
    $result= $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        echo $e;
    }
}
public function store($item_id,$product_id,$qty,$notes) {
    $stmt = $this->db->prepare("INSERT INTO  j_product_item (item_id,product_id,qty,notes) VALUES (?,?,?,?)");
 
    return   $stmt->execute([ $item_id,$product_id,$qty,$notes]);}


public function deletebyid($id)  {
    // Use prepared statement to delete
$stmt = $this->db->prepare("DELETE FROM j_product_item WHERE rec_id = ?");
$stmt->execute([$id]);

if ($stmt->execute()) {
  echo "success";
} else {
  echo "error";
}


 
}

}