<?php

ob_start();
session_start();

if (!isset($_SESSION['id']) || $_SESSION['id'] == ""){
    http_response_code(400); exit;
}

if (isset($_SESSION['user_type'])){
    if ($_SESSION['user_type'] != 4){
        http_response_code(400); exit;

    }
} else{
    http_response_code(400); exit;
}


$products = array();

$id = $_SESSION['id'];

$conn = mysqli_connect("localhost", "root", "", "marketplace"); // database connection

// products
$products_sql = "SELECT products.id, products.name, products.price, cart.quantity AS quantity, cart.id AS cartID FROM products JOIN users JOIN cart ON users.id = cart.product_id AND products.id = cart.product_id";
$statement = $conn->prepare($products_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($products, $row);
    }
}

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($products);

?>
