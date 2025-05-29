<?php
require_once __DIR__ . '/../config/database.php';

class AreaModel
{
    private PDO $db;
    private $conn;
    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    function get()
    {
        try {

            $stmt = $this->db->query("SELECT * FROM del_area ORDER BY area_id DESC ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $errors = $e->getMessage();
            die(['error' => 'Query failed' + $e->getMessage()]);
        }
        exit();

    }

    function getselected()
    {
        try {

            $stmt = $this->db->query("SELECT area_id,area_name,governorate FROM del_area  ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {

            die($e->getMessage());
        }
        exit();

    }
    public function store($area_name, $area_desc, $zone_id, $notes)
    {
        $stmt = $this->db->prepare("INSERT INTO  del_area (area_name, area_desc, zone_id, notes) VALUES (?,?,?,?)");

        return $stmt->execute([$area_name, $area_desc, $zone_id, $notes]);
    }


    function storeareas($agent_id, $area_id)
    {
        $stmt = $this->db->prepare("INSERT INTO  j_area_agent (area_id, agent_id) VALUES (?,?)");
        return $stmt->execute([$agent_id, $area_id]);
    }

}