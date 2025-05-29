
<?php
require_once __DIR__.'/../config/database.php';

class AccGlModel {
    private PDO $db;
    private $conn;
    public function __construct() {
        $this->db = (new Database())->connect();
    }

function get(){
    try {
        
$stmt = $this->db->query("SELECT * FROM acc_gl ORDER BY gl_id DESC ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        die(['error' => 'Query failed'+ $e->getMessage()]);
    }
    exit();

}
public function getselected(){
try {
        
$stmt = $this->db->query("SELECT id,account_code,account_name,account_type ,parent_account FROM chart_of_accounts WHERE marked!='yes' ORDER BY account_code DESC ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
       $errors = $e->getMessage();
        die( $e->getMessage());
    }
    exit();

}
public function store($account_code, $account_name,$account_type,$parent_account,$parent_code,$normal_balance,$account_description) {
    $stmt = $this->db->prepare("INSERT INTO  chart_of_accounts (account_code, account_name,account_type,parent_account,parent_code,normal_balance,account_description) VALUES (?,?,?,?,?,?,?)");
 
    return   $stmt->execute([$account_code, $account_name,$account_type,$parent_account,$parent_code,$normal_balance,$account_description]);
}

}
?>
