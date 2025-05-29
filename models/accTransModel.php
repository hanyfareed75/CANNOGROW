<?php
require_once __DIR__. '/../config/database.php';

class AccTransModel {
    private PDO $db;
    public function __construct() {
        $this->db = (new Database())->connect();
    }

function get(){
    try {
        
    $stmt = $this->db->query("SELECT * FROM acc_trans ORDER BY trans_id DESC ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        return $errors;
    }
    exit();

}

public function store($trans_value, $trans_description,  $gl_id,$trans_type,$invoice_id,$invoice_path) {
    try {
    $stmt = $this->db->prepare("INSERT INTO  acc_trans (trans_value, trans_description, gl_id,trans_type,invoice_id,invoice_path) VALUES (?,?,?,?,?,?)");
 
    return   $stmt->execute([$trans_value, $trans_description,  $gl_id,$trans_type,$invoice_id,$invoice_path]);
    }catch(Exception $e){
        return $e;
    }
}

}
