<?php
require_once __DIR__ . '/../models/customerModel.php';
require_once __DIR__ . '/../models/areaModel.php';
require_once __DIR__ . '/../models/zoneModel.php';
class CustomerController
{
    private $model;
    private $SubModel;
    private $SubModel2;

    public function __construct()
    {
        $this->model = new customerModel();
        $this->SubModel = new areaModel();
        $this->SubModel2 = new zoneModel();
    }
    public function get()
    {

        $customer = $this->model->get();
        $selecteditems = $this->SubModel->getselected();
        $selecteditems2 = $this->SubModel2->getselected();
        require 'views/customers.php';
    }
    public function getAPI()
    {
        return $this->model->get();
    }
    public function getAPI2()
    {
        return $this->SubModel->get();
    }
    public function getAPI3()
    {
        return $this->SubModel2->get();
    }
    public function findById($params)
    {$id=$params['id'] ?? null;
   
        return $this->model->findById($params['id']); /* return customer by ID */
    }
    /**
     * Update customer details
     * @param array $input
     * @return array
     * @throws Exception
     */
    public function update($input)
{
    try {
        // Validate required fields
        $requiredFields = ['cust_id', 'cust_name', 'mobile_1', 'address', 'area'];
        foreach ($requiredFields as $field) {
            if (!isset($input[$field]) || empty($input[$field])) {
                throw new Exception("Missing required field: {$field}");
            }
        }

        // Validate customer exists
        $customer = $this->model->findById($input['cust_id']);
        if (!$customer) {
            throw new Exception('Customer not found');
        }

        // Perform update
        $updated = $this->model->update(
            $input['cust_id'],
            $input['cust_name'],
            $input['mobile_1'],
            $input['mobile_2'] ?? '',  // Optional field
            $input['address'],
            $input['area']
        );

        if (!$updated) {
            throw new Exception('Failed to update customer');
        }

        return [
            'cust_id' => $input['cust_id'],
            'message' => 'Customer updated successfully'
        ];

    } catch (Exception $e) {
        throw new Exception('Update failed: ' . $e->getMessage());
    }
}
    public function delete($input): bool
    {
        if (!isset($input['cust_id']) || empty($input['cust_id'])) {
            throw new Exception('Customer ID is required for deletion');
        }
        $id = $input['cust_id'];
        // Validate customer exists
        $customer = $this->model->findById($id);
        if (!$customer) {
            throw new Exception('Customer not found');
        }
        // Perform deletion
        if (!$this->model->delete($id)) {
            throw new Exception('Failed to delete customer');
        }
        // Return success response
        return true;
    }
   
    /**
     * Store a new customer
     * @param string $cust_name
     * @param string $mobile_1
     * @param string $mobile_2
     * @param string $address
     * @param string $area
     * @return string
     */

    public function store($input)
    {
        $cust_name = $input['cust_name'] ?? '';
        $mobile_1 = $input['mobile_1'] ?? '';
        $mobile_2 = $input['mobile_2'] ?? '';
        $address = $input['address'] ?? '';
        $area = $input['area'] ?? '';

        // Validate required fields
        if (empty($cust_name) || empty($mobile_1) || empty($address) || empty($area)) {
            return "Missing required fields.";
        }

        // Store the customer
       
        if ($this->model->store($cust_name, $mobile_1, $mobile_2, $address, $area)) {
            return "Customer stored successfully.";
        } else {
            return "Failed to store customer.";
        }
    }
  }
//
// Example usage
// $controller = new CustomerController();
// $result = $controller->getAPI();
// echo json_encode($result); 