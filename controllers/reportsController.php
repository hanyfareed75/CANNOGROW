<?php
require_once __DIR__ . '/../models/reportsModel.php';

class ReportsController
{
  public function __construct()
  {
    $this->model = new ReportsModel();
  }


  /**
   * Generate customer report with optional filters
   * @param array $filters Optional filters (date_from, date_to, area, status)
   * @return array Customer report data
   */
  public function generateCustomerReport(array $filters = []): array
  {
    return $this->model->generateCustomerReport($filters);
  }


  /**
   * Generate sales report with optional filters
   * @param array $filters Optional filters (date_from, date_to, area, status)
   * @return array Sales report data
   */
  public function generateSalesReport(array $filters = []): array
  {
    return $this->model->generateSalesReport($filters);
  }


  /**
   * Generate agent performance report with optional filters
   * @param array $filters Optional filters (date_from, date_to, area, status)
   * @return array Agent performance report data
   */
  public function generateAgentPerformanceReport(array $filters = []): array
  {
    return $this->model->generateAgentPerformanceReport($filters);
  }
}
