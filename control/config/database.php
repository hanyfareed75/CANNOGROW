<?php

class Database
{
  private $host = "sql203.infinityfree.com";
  private $db_name = "if0_38844204_cannigrow";
  private $username = "if0_38844204";
  private $password = "STidC4Q5MfL";
  private $conn;

  /**
   * Connect to the database
   * @return PDO
   * @throws Exception
   */
  public function connect(): PDO
  {
    try {
      if ($this->conn === null) {
        $this->conn = new PDO(
          "mysql:host=$this->host;dbname=$this->db_name;charset=utf8mb4",
          $this->username,
          $this->password,
          [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
          ]
        );
      }
      return $this->conn;
    } catch (PDOException $e) {
      throw new Exception("Connection error: " . $e->getMessage());
    }
  }

  /**
   * Begin a database transaction
   * @return bool
   * @throws PDOException
   */
  public function beginTransaction(): bool
  {
    return $this->connect()->beginTransaction();
  }

  /**
   * Commit the current transaction
   * @return bool
   * @throws PDOException
   */
  public function commit(): bool
  {
    return $this->connect()->commit();
  }

  /**
   * Rollback the current transaction
   * @return bool
   * @throws PDOException
   */
  public function rollback(): bool
  {
    return $this->connect()->rollBack();
  }

  /**
   * Close the database connection
   * @return void
   */
  public function close(): void
  {
    $this->conn = null;
  }

  /**
   * Get the current connection instance
   * @return PDO|null
   */
  public function getConnection(): ?PDO
  {
    return $this->conn;
  }
}
