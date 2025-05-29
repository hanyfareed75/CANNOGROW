<?php
require_once __DIR__ . '/../config/database.php';

class CustomerModel
{
    private PDO $db;
    private $conn;
    public function __construct()
    {
        $this->db = (new Database())->connect();
    }
    /**
     * Get all agents ordered by ID descending
     * @return array
     * @throws PDOException
     */
    function get()
    {
        try {

            $stmt = $this->db->query("SELECT s_customer.*, del_area.area_name AS area_name FROM s_customer INNER JOIN del_area ON s_customer.area = del_area.area_id ORDER BY area_name  DESC ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Failed to fetch customers: " . $e->getMessage());
        }
    }


    /**
     * Find agent by ID
     * @param int $id
     * @return array|false
     * @throws PDOException
     */
    public function findById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM s_customer WHERE cust_id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Failed to find Customer: " . $e->getMessage());
        }
    }

    /**
     * Store a new customer
     * @param string $cust_name
     * @param string $mobile_1
     * @param string $mobile_2
     * @param string $address
     * @param string $area
     * @return bool
     * @throws Exception
     */
    public function store($cust_name, $mobile_1, $mobile_2, $address, $area): bool
    {
        try {
            // Ensure mobile numbers start with '0' if not present
            $mobile_1 = str_starts_with($mobile_1, '0') ? $mobile_1 : '0' . $mobile_1;
            $mobile_2 = $mobile_2 ? (str_starts_with($mobile_2, '0') ? $mobile_2 : '0' . $mobile_2) : null;

            $sql = "INSERT INTO s_customer (cust_name, mobile_1, mobile_2, address, area) 
                    VALUES (?, ?, ?, ?, ?)";
                    
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$cust_name, $mobile_1, $mobile_2, $address, $area]);
        } catch (PDOException $e) {
            error_log("Error storing customer: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing customer
     * @param int $id
     * @param string $cust_name
     * @param string $mobile_1
     * @param string $mobile_2
     * @param string $address
     * @param string $area
     * @return bool
     * @throws Exception
     */
    public function update($id, $cust_name, $mobile_1, $mobile_2, $address, $area): bool
    {
        try {
            // Ensure mobile numbers start with '0' if not present
            $mobile_1 = str_starts_with($mobile_1, '0') ? $mobile_1 : '0' . $mobile_1;
            $mobile_2 = $mobile_2 ? (str_starts_with($mobile_2, '0') ? $mobile_2 : '0' . $mobile_2) : null;

            $sql = "UPDATE s_customer 
                    SET cust_name = ?, 
                        mobile_1 = ?, 
                        mobile_2 = ?, 
                        address = ?, 
                        area = ? 
                    WHERE cust_id = ?";
                    
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$cust_name, $mobile_1, $mobile_2, $address, $area, $id]);
        } catch (PDOException $e) {
            error_log("Error updating customer: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete a customer by ID
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM s_customer WHERE cust_id = ?");
        try {
            return   $stmt->execute([$id]);
        } catch (Exception $e) {
            throw new PDOException("Failed to delete Customer: " . $e->getMessage());
        }
    }
    /**
     * Begin a database transaction
     * @return bool
     * @throws PDOException
     */
    public function beginTransaction(): bool
    {
        return $this->db->beginTransaction();
    }
    /**
     * Commit the current transaction
     * @return bool
     * @throws PDOException
     */
    public function commit(): bool
    {
        return $this->db->commit();
    }
    /**
     * Rollback the current transaction
     * @return bool
     * @throws PDOException
     */
    public function rollback(): bool
    {
        return $this->db->rollBack();
    }
    /**
     * Get the last inserted ID
     * @return int
     */
    public function lastInsertId(): int
    {
        return $this->db->lastInsertId();
    }
    /**
     * Close the database connection
     * @return void
     */
   

     //generate functions to build reports related to customer



}
