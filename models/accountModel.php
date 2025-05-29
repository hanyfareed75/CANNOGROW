<?php
require_once __DIR__ . '/../config/database.php';
include 'queries/q_orders.php';

class AccountModel
{
  public function __construct()
  {
    $this->db = (new Database())->connect();
  }

  //database related functions is here
  //chart_of_accounts  
  //SELECT `id`, `account_code`, `account_name`, `account_type`, `parent_account`, `parent_code`, `normal_balance`, `account_description`, `marked` FROM `chart_of_accounts` WHERE 1

  //entries 
  //SELECT `id`, `date`, `description`, `created_at` FROM `entries` WHERE 1

  //entry_lines
  //SELECT `id`, `entry_id`, `account_id`, `debit`, `credit` FROM `entry_lines` WHERE 1

  //add sales entry
  public function addSalesEntry($data)
  {
    $sql = "INSERT INTO entries (date, description, created_at) VALUES (:date, :description, NOW())";
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':date', $data['date']);
    $stmt->bindParam(':description', $data['description']);
    if ($stmt->execute()) {
      return $this->db->lastInsertId();
    }
    return false;
  }
  //add entry lines
  public function addEntryLines($entryId, $lines)
  {
    $sql = "INSERT INTO entry_lines (entry_id, account_id, debit, credit) VALUES (:entry_id, :account_id, :debit, :credit)";
    $stmt = $this->db->prepare($sql);
    foreach ($lines as $line) {
      $stmt->bindParam(':entry_id', $entryId);
      $stmt->bindParam(':account_id', $line['account_id']);
      $stmt->bindParam(':debit', $line['debit']);
      $stmt->bindParam(':credit', $line['credit']);
      if (!$stmt->execute()) {
        return false;
      }
    }
    return true;
  }
  
}

