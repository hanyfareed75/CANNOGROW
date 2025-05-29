<?php
require_once 'models/itemsModel.php';

class ItemsController {
private $model;


public function __construct() {
    $this->model = new ItemModel();
}
    public function getItems() {
        $items = $this->model->getallitems();
         require 'views/items.php';  // Make sure no output before header() call
        }

    public function store($item_name, $measure, $description) {
        
        if ($this->model->insertItem($item_name, $measure, $description)) {
            // echo "ITEM added successfully!";
           header("Location: /managment/?items");
        } else {
            echo "Failed to add ITEM.";
        }
    }
}