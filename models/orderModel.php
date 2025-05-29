<?php
require_once __DIR__ . '/../config/database.php';
include 'queries/q_orders.php';

class OrderModel
{
    private PDO $db;
    private $conn;

    /**
     * OrderModel constructor.
     * Initializes a new database connection.
     */

    public function __construct()
    {
        $this->db = (new Database())->connect();

    }

    function get()
    {
        $stmt = $this->db->query("SELECT * FROM s_orders ORDER BY order_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);



    }
    function getOrderDetails()
    {
    }
    function getNonDelivaredOrders()
    {

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

}