<?php
require_once __DIR__ . '/../config/database.php';

class ZoneModel
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

            $stmt = $this->db->query("SELECT * FROM del_zone ORDER BY zone_id DESC ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {

            die($e->getMessage());
        }
        exit();

    }
    function getselected()
    {
    }
    public function store($area_name, $area_desc, $zone_id, $notes)
    {
        $stmt = $this->db->prepare("INSERT INTO  del_area (area_name, area_desc, zone_id, notes) VALUES (?,?,?,?)");

        return $stmt->execute([$area_name, $area_desc, $zone_id, $notes]);
    }

}