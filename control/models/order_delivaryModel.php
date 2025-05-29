<?php
require_once __DIR__ . '/../config/database.php';
include 'queries/q_orders.php';

class OrderDelivaryModel
{
    private PDO $db;
    private $conn;
    
    public function __construct()
    {
        $this->db = (new Database())->connect();
    }
    //getallorders with order_status='Ordered' and customers name and ID
    public function get()
    {
     
        $sql=" SELECT distinct o.*, c.cust_name, c.mobile_1,
                    p.name_ar, p.unit_price,
                    op.qty, op.total
                FROM s_orders o
                INNER JOIN s_customer c ON o.cust_id = c.cust_id
                INNER JOIN j_order_product op ON o.order_id = op.order_id
                INNER JOIN s_product p ON op.product_id = p.product_id
                WHERE o.order_status = 'Ordered'
                ORDER BY o.created_at DESC"

                ;
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function getAllOrdersBycustomer(){
  $sql="SELECT 
  c.cust_id,
  c.cust_name,
  c.mobile_1,
  c.address,
  a.area_id,
  a.area_name,
a.delivaryFees,
  COUNT(DISTINCT o.order_id) AS total_orders,
  SUM(op.total) AS total_spent
FROM s_orders o
INNER JOIN s_customer c ON o.cust_id = c.cust_id
INNER JOIN del_area a ON a.area_id=c.area
INNER JOIN j_order_product op ON o.order_id = op.order_id
INNER JOIN s_product p ON op.product_id = p.product_id
WHERE o.order_status = 'Ordered'
GROUP BY c.cust_name, c.mobile_1
ORDER BY total_spent DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getOrdersByCustomerID($cust_id)
    {
        $sql = "SELECT distinct o.*, c.cust_id,c.cust_name, c.mobile_1,
                    p.name_ar, p.unit_price,
                    op.qty, op.total
                FROM s_orders o
                INNER JOIN s_customer c ON o.cust_id = c.cust_id
                INNER JOIN j_order_product op ON o.order_id = op.order_id
                INNER JOIN s_product p ON op.product_id = p.product_id
                WHERE c.cust_id = ? AND o.order_status = 'Ordered'
                ORDER BY o.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cust_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
  
}
    public function getOrderProducts(){
        global $order_products;
        $stmt = $this->db->query($order_products);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //create function to update order status from s_orders to Delivered
    public function updateDelivaryStatus($order_id)
    {
      try {
            $stmt = $this->db->prepare("UPDATE s_orders SET order_status = 'Delivered' WHERE order_id = ?");
            $stmt->execute([$order_id]);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }
    //create function to update order status from s_orders to Cancelled
    public function updateCancelledStatus($order_id)
    {
        try {
            $stmt = $this->db->prepare("UPDATE s_orders SET order_status = 'Cancelled' WHERE order_id = ?");
            $stmt->execute([$order_id]);
    }
    catch (Exception $e) {
        echo $e;
    }
    }
function storeDelivaryTrane( $agent_id, $order_id, $delivary_date, $agent_delivaryFees, $actual_delivaryfees) {
    try {
        $stmt = $this->db->prepare("INSERT INTO `j_del_orders_cust`(`order_id`, `cust_id`, `agent_id`, `date_out`, `agent_delivaryFees`, `actual_delivaryfees`, `status`) VALUES (?,?,?,?,?,?,'Pending')");
        $stmt->execute([$_POST['agent_id'], $_POST['order_id'], $_POST['delivary_date']]);
        return true;
    } catch (Exception $e) {
        echo $e;
    }
}
 
// Example PHP backend code
function createDeliveryTransaction($agent_id, $order_ids, $notes, $agent_fees) {
    try {
        // Start transaction
        $this->db->beginTransaction();

        // Insert main transaction record
        $sql = "INSERT INTO delivery_transactions (agent_id, agent_fees, notes) 
                VALUES (:agent_id, :agent_fees, :notes)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':agent_id' => $agent_id,
            ':agent_fees' => $agent_fees,
            ':notes' => $notes
        ]);
        
        $trans_id = $this->db->lastInsertId();

        // Insert order relationships
        $sql = "INSERT INTO delivery_transaction_orders (trans_id, order_id) 
                VALUES (:trans_id, :order_id)";
        
        $stmt = $this->db->prepare($sql);
        
        foreach ($order_ids as $order_id) {
            $stmt->execute([
                ':trans_id' => $trans_id,
                ':order_id' => $order_id
            ]);
        }
        // Update order status to 'Delivered'
        if (empty($order_ids)) {
            throw new InvalidArgumentException("Order IDs must be a non-empty array");
        }
$sql= "UPDATE s_orders SET order_status = 'Delivered' WHERE order_id IN (" . implode(',', array_fill(0, count($order_ids), '?')) . ")";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($order_ids);
        
        // Commit transaction
        $this->db->commit();
        return true;

    } catch (Exception $e) {
        $this->db->rollBack();
        throw $e;
    }
}

public function store($created_at, $cust_id, $order_value, $sp_discounts, $order_status, $notes)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO  s_orders (created_at, cust_id, order_value, sp_discounts, order_status, notes ) VALUES (?,?,?,?,?,?)");
            $stmt->execute([$created_at, $cust_id, $order_value, $sp_discounts, $order_status, $notes]);


            return true;
        } catch (Exception $e) {
            echo $e;
        }

    }
    public function storeitems($order_id, $product_id, $qty, $total, $notes)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO  j_order_product (order_id, product_id, qty,total, notes) VALUES (?,?,?,?,?)");
            $stmt->execute([$order_id, $product_id, $qty, $total, $notes]);

            return true;
        } catch (Exception $e) {
            echo $e;
        }

    }

    public function getOrderSummary(): array {
        try {
            global $order_summary;
            $stmt = $this->db->query($order_summary);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting order summary: " . $e->getMessage());
            throw $e;
        }
    }

    public function getOrderWithProducts(int $orderId): array {
        try {
            $sql = "
                SELECT 
                    o.*, c.cust_name, c.mobile_1,
                    p.name_ar, p.unit_price,
                    op.qty, op.total
                FROM s_orders o
                INNER JOIN s_customer c ON o.cust_id = c.cust_id
                INNER JOIN j_order_product op ON o.order_id = op.order_id
                INNER JOIN s_product p ON op.product_id = p.product_id
                WHERE o.order_id = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$orderId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting order details: " . $e->getMessage());
            throw $e;
        }
    }
}