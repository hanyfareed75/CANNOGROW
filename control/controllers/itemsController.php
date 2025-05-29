<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

namespace App\Controllers;
// This file is part of the Inventory Management System.
// It is responsible for handling item-related operations such as fetching and storing items.
// This file is part of the Inventory Management System.

// require_once 'models/itemsModel.php';
require __DIR__ . '/../vendor/autoload.php';
use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;
use App\Models\ItemModel;
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