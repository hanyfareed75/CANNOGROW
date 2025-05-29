<?php
require_once __DIR__ . '/../config/database.php';
class ReportsModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

     
    /**
     * Generate comprehensive customer reports with optional filters
     * @param array $filters Optional filters (date_from, date_to, area, status)
     * @return array Customer report data
     * @throws PDOException
     */
    public function generateCustomerReport(array $filters = []): array
    {
        try {
            $sql = "SELECT 
                    c.cust_id,
                    c.cust_name,
                    c.mobile_1,
                    c.address,
                    c.area,
                    COUNT(o.order_id) as total_orders,
                    SUM(o.order_value) as total_spending,
                    MAX(o.created_at) as last_order_date,
                    COUNT(CASE WHEN o.order_status = 'completed' THEN 1 END) as completed_orders,
                    COUNT(CASE WHEN o.order_status = 'pending' THEN 1 END) as pending_orders
                    FROM s_customer c
                    LEFT JOIN s_orders o ON c.cust_id = o.cust_id
                    WHERE 1=1";
            
            $params = [];
            
            // Add optional filters
            if (!empty($filters['date_from'])) {
                $sql .= " AND o.order_date >= ?";
                $params[] = $filters['date_from'];
            }
            
            if (!empty($filters['date_to'])) {
                $sql .= " AND o.order_date <= ?";
                $params[] = $filters['date_to'];
            }
            
            if (!empty($filters['area'])) {
                $sql .= " AND c.area = ?";
                $params[] = $filters['area'];
            }
            
            $sql .= " GROUP BY c.cust_id
                      ORDER BY total_spending DESC";
    
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Calculate additional metrics
            foreach ($results as &$row) {
                $row['average_order_value'] = $row['total_orders'] > 0 
                    ? round($row['total_spending'] / $row['total_orders'], 2) 
                    : 0;
                
                $row['completion_rate'] = $row['total_orders'] > 0 
                    ? round(($row['completed_orders'] / $row['total_orders']) * 100, 2) 
                    : 0;
            }
    
            // Add summary statistics
            $summary = [
                'total_customers' => count($results),
                'total_revenue' => array_sum(array_column($results, 'total_spending')),
                'average_customer_value' => round(array_sum(array_column($results, 'total_spending')) / count($results), 2),
                'total_orders' => array_sum(array_column($results, 'total_orders')),
            ];
    
            return [
                'summary' => $summary,
                'customers' => $results,
                'details' => $results
            ];
    
        } catch (PDOException $e) {
            throw new PDOException("Failed to generate customer report: " . $e->getMessage());
        }
    }
}