<?php
require_once __DIR__ . '/vendor/autoload.php';
// require_once __DIR__ . '/vendor/autoload.php';
echo "Welcome to the API!<br>" getcwd() . "<br>";
use App\Controllers\ItemsController;
use App\Controllers\StoreController;
use App\Controllers\ProductController;
use App\Controllers\OrderController;
use App\Controllers\CustomerController;
// Initialize error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'controllers/apiController.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['items'])) {
        require_once 'controllers/itemsController.php';
        $controller = new ItemsController();
        $item_name = $_POST['item_name'] ?? '';
        $measure = $_POST['measure'] ?? '';
        $description = $_POST['description'] ?? '';
        $controller->store($item_name, $measure, $description);
    } elseif (isset($_GET['customers'])) {
        require_once 'controllers/customerController.php';
        $controller = new CustomerController();
        $cust_name = $_POST['cust_name'] ?? '';
        $mobile_1 = $_POST['mobile_1'] ?? '';
        $mobile_2 = $_POST['mobile_2'] ?? '';
        $address = $_POST['address'] ?? '';
        $area = $_POST['area'] ?? '';


        $controller->store($cust_name, $mobile_1, $mobile_2, $address, $area);


    } elseif (isset($_GET['products'])) {
        require_once 'controllers/productController.php';
        $controller = new ProductController();
        $item_name = $_POST['item_name'] ?? '';
        $measure = $_POST['measure'] ?? '';

        $description = $_POST['description'] ?? '';

        $controller->store($item_name, $measure, $description);


    } elseif (isset($_GET['zones'])) {
        require_once 'controllers/zoneController.php';
        $controller = new ZoneController();
        $zone_name = $_POST['zone_name'] ?? '';
        $zone_desc = $_POST['zone_desc'] ?? '';

        $controller->store($zone_name, $zone_desc);


    } elseif (isset($_GET['areas'])) {
        require_once 'controllers/areaController.php';
        $controller = new AreaController();
        $area_name = $_POST['area_name'] ?? '';
        $area_desc = $_POST['area_desc'] ?? '';
        $zone_id = $_POST['zone_id'] ?? '';
        $notes = $_POST['notes'] ?? '';

        $controller->store($area_name, $area_desc, $zone_id, $notes);


    }
    elseif (isset($_GET['agents'])) {
        require_once 'controllers/agentController.php';
        $controller = new AgentController();
        $agent_name = $_POST['agent_name'] ?? '';
        $address = $_POST['address'] ?? '';
        $mobile_1 = $_POST['mobile_1'] ?? '';
        $mobile_2 = $_POST['mobile_2'] ?? '';
        $notes = $_POST['notes'] ?? '';

        $controller->store($agent_name, $address, $mobile_1, $mobile_2, $notes);


    }

    // elseif(isset($_GET['recipe'])){
    // require_once 'controllers/recipeController.php';
    // $controller = new RecipeController();
    // $rec_name = $_POST['rec_name'] ?? '';
    // $product_id = $_POST['product_id'] ?? '';
    // $item_id = $_POST['item_id'] ?? '';
    //  $rec_value = $_POST['rec_value'] ?? '';
    // $notes = $_POST['notes'] ?? '';

    // $controller->store( $rec_name, $product_id,$item_id,$rec_value,$notes);


    // }
    else {
         echo 'No this to Post ........';
    }

}


if (isset($_GET['items'])) {
    // require_once 'controllers/itemsController.php';
    $controller = new ItemsController();
    $controller->getItems();
} elseif (isset($_GET['store'])) {
    // require_once 'controllers/storeController.php';

    $controller = new StoreController();
    $controller->getStore();
} elseif (isset($_GET['products'])) {
    // require_once 'controllers/productController.php';
    $controller = new ProductController();
    $controller->getProduct();
} elseif (isset($_GET['orders'])) {
    require_once 'controllers/orderController.php';
    $controller = new OrderController();
    $controller->get();
} elseif (isset($_GET['customers'])) {
    require_once 'controllers/customerController.php';

    $controller = new customerController();
    $controller->get();
} elseif (isset($_GET['zones'])) {
    require_once 'controllers/zoneController.php';
    $controller = new ZoneController();
    $controller->get();
} elseif (isset($_GET['areas'])) {
    require_once 'controllers/areaController.php';
    $controller = new AreaController();
    $controller->get();
} elseif (isset($_GET['agents'])) {
    require_once 'controllers/agentController.php';
    $controller = new AgentController();
    $controller->get();
} elseif (isset($_GET['accTrans'])) {
    require_once 'controllers/accTransController.php';
    $controller = new AccTransController();
    $controller->get();
} elseif (isset($_GET['recipe'])) {
    require_once 'controllers/recipeController.php';
    $controller = new recipeController();
    $controller->get();
} 
elseif (isset($_GET['orderDelivary'])) {
    require_once 'controllers/orderDelivaryController.php';
    $controller = new OrderDelivaryController();
    $controller->get();
} 
elseif (isset($_GET['reports'])) {
include 'views/reports.php';
} 
else {
    include 'landingPage.php';
}

// if ($_GET['url']==='api/get-data'){
// $apicontroller = new apiController;
// $apicontroller->getItems();
// }

// // Load routes
// require_once 'routes.php';

// // Get the current path
// $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
// $path = trim($path, '/');

// // Check if route exists
// if (array_key_exists($path, $routes)) {
//    // Call the handler
//    call_user_func($routes[$path]);
// } else {
//    // 404 Not Found
//    http_response_code(404);
//    echo "404 - Page not found";
// }

?>