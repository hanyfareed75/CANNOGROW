<?php
require_once __DIR__ . '/../models/areaModel.php';
require_once __DIR__ . '/../models/zoneModel.php';


class AreaController
{
    private $model;
    private $SubModel;
    private $SubModel2;

    public function __construct()
    {
        $this->model = new AreaModel();
        $this->SubModel = new zoneModel();

    }
    public function get()
    {


        $result = $this->model->get();
        $selecteditems = $this->SubModel->getselected();


        require __DIR__ . '/../views/area.php';


    }

    public function store($area_name, $area_desc, $zone_id, $notes)
    {
        try {
            if ($this->model->store($area_name, $area_desc, $zone_id, $notes)) {

                header("Location: index.php?areas");
            } else {
                echo "Failed to add Area.";
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
}