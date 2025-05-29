<?php

require_once __DIR__ . '/../models/orderModel.php';
require_once __DIR__ . '/../models/productModel.php';
require_once __DIR__ . '/../models/order_delivaryModel.php';
require_once __DIR__ . '/../models/agentsModel.php';

class OrderDelivaryController
{
    private OrderDelivaryModel $model;
    private ProductModel $productModel;
    private AgentsModel $agentModel;

    public function __construct()
    {
        $this->model = new OrderDelivaryModel();
        $this->productModel = new ProductModel();
        $this->agentModel = new AgentsModel();
    }

    /**
     * Get delivery page data
     * @return void
     */
    public function get(): void
    {
        try {
            $result = $this->model->getAllOrdersBycustomer();
            $selectedItems = $this->productModel->getselected();
            $agents = $this->agentModel->get();
            
            require __DIR__ . '/../views/orderDelivary.php';
        } catch (Exception $e) {
            error_log("Error in get(): " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }
    public function getAllOrdersBycustomer(){
      return $this->model->getAllOrdersBycustomer();
        
    }
public function getOrdersByCustomerID($input): array
    {
        try {
            if (!isset($input['cust_id']) || empty($input['cust_id'])) {
                return [
                    'success' => false,
                    'error' => 'Customer ID is required'
                ];
            }

            return $this->model->getOrdersByCustomerID($input['cust_id']);
           
        } catch (Exception $e) {
            error_log("Error fetching orders by customer ID: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to fetch orders for the customer'
            ];
        }
    }
    
    /**
     * Get orders data for API
     * @return array
     */
    public function getAPI(): array
    {
        try {
            return [
                'success' => true,
                'data' => $this->model->get()
            ];
        } catch (Exception $e) {
            error_log("Error in getAPI(): " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to fetch orders'
            ];
        }
    }
public function getOrderWithProducts(int $orderId): array {
        try {
            $orderData = $this->model->getOrderWithProducts($orderId);
            if (empty($orderData)) {
                return [
                    'success' => false,
                    'error' => 'Order not found'
                ];
            }
            return [
                'success' => true,
                'data' => $orderData
            ];
        } catch (Exception $e) {
            error_log("Error fetching order with products: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to fetch order with products'
            ];
        }
}
public function storeDelivaryTrane($input): array {
    try {
        $required = ['agent_id', 'order_id','cust_id', 'delivary_date', 'agent_delivaryFees', 'actual_delivaryfees'];
        foreach ($required as $field) {
            if (!isset($input[$field])) {
                throw new InvalidArgumentException("Missing required field: {$field}");
            }
        }

        $success = $this->model->storeDelivaryTrane(
            $input['agent_id'],
            $input['order_id'],
            $input['cust_id'],
            $input['delivary_date'],
            $input['agent_delivaryFees'],
            $input['actual_delivaryfees']
        );

        return [
            'success' => $success,
            'message' => $success ? 'Delivery transaction stored successfully' : 'Failed to store delivery transaction'
        ];
    } catch (Exception $e) {
        error_log("Error storing delivery transaction: " . $e->getMessage());
        return [
            'success' => false,
            'error' => $e instanceof InvalidArgumentException ? $e->getMessage() : 'Failed to store delivery transaction'
        ];
    } 
}
  
function createDeliveryTransaction(array $input): array {
    try {
        $required = ['agent_id', 'order_ids', 'notes', 'agent_fees'];
        foreach ($required as $field) {
            if (!isset($input[$field])) {
                throw new InvalidArgumentException("Missing required field: {$field}");
            }
        }
        if (!is_array($input['order_ids']) || empty($input['order_ids'])) {
            throw new InvalidArgumentException("Order IDs must be a non-empty array");
        }
        $success = $this->model->createDeliveryTransaction(
            $input['agent_id'],
            $input['order_ids'],
            $input['notes'],
            $input['agent_fees']
        );
        return [
            'success' => $success,
            'message' => $success ? 'Delivery transaction created successfully' : 'Failed to create delivery transaction'
        ];
    } catch (Exception $e) {
        error_log("Error creating delivery transaction: " . $e->getMessage());
        return [
            'success' => false,
            'error' => $e instanceof InvalidArgumentException ? $e->getMessage() : 'Failed to create delivery transaction'
        ];
    }   
}
    /**
     * Update order delivery status
     * @param int $orderId
     * @return array
     */
    public function updateDelivaryStatus(int $orderId): array
    {
        try {
            $success = $this->model->updateDelivaryStatus($orderId);
            return [
                'success' => $success,
                'message' => $success ? 'Order updated successfully' : 'Failed to update order'
            ];
        } catch (Exception $e) {
            error_log("Error updating delivery status: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to update delivery status'
            ];
        }
    }

    /**
     * Get order products
     * @return array
     */
    public function getOrderProducts(): array
    {
        try {
            return [
                'success' => true,
                'data' => $this->model->getOrderProducts()
            ];
        } catch (Exception $e) {
            error_log("Error fetching order products: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to fetch order products'
            ];
        }
    }

    /**
     * Store new order
     * @param array $orderData
     * @return array
     */
    public function store(array $orderData): array
    {
        try {
            $required = ['created_at', 'cust_id', 'order_value', 'sp_discounts', 'order_status'];
            foreach ($required as $field) {
                if (!isset($orderData[$field])) {
                    throw new InvalidArgumentException("Missing required field: {$field}");
                }
            }

            $success = $this->model->store(
                $orderData['created_at'],
                $orderData['cust_id'],
                $orderData['order_value'],
                $orderData['sp_discounts'],
                $orderData['order_status'],
                $orderData['notes'] ?? null
            );

            return [
                'success' => $success,
                'message' => $success ? 'Order created successfully' : 'Failed to create order'
            ];
        } catch (Exception $e) {
            error_log("Error storing order: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e instanceof InvalidArgumentException ? $e->getMessage() : 'Failed to create order'
            ];
        }
    }

    /**
     * Store order items
     * @param array $itemData
     * @return array
     */
    public function storeItems(array $itemData): array
    {
        try {
            $required = ['order_id', 'product_id', 'qty', 'total'];
            foreach ($required as $field) {
                if (!isset($itemData[$field])) {
                    throw new InvalidArgumentException("Missing required field: {$field}");
                }
            }

            $success = $this->model->storeitems(
                $itemData['order_id'],
                $itemData['product_id'],
                $itemData['qty'],
                $itemData['total'],
                $itemData['notes'] ?? null
            );

            return [
                'success' => $success,
                'message' => $success ? 'Order items stored successfully' : 'Failed to store order items'
            ];
        } catch (Exception $e) {
            error_log("Error storing order items: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e instanceof InvalidArgumentException ? $e->getMessage() : 'Failed to store order items'
            ];
        }
    }
}