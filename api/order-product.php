<?php

include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $id = $data->id;
    $quantity = $data->quantity;
    $product_id = $data->productid;

$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName);// database connection

    $sql = "INSERT INTO orders (product_id, user_id, quantity) VALUES (?,?,?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param('sss', $product_id, $id, $quantity);
    $statement->execute();
    $result = $statement->get_result();

//myorders
$myorders = array();
    $orderssql = "SELECT o.id,p.name,o.quantity,p.price FROM orders o,products p where user_id = $id and p.id =o.product_id";
    $statement = $conn->prepare($orderssql);
    $statement->execute();
    $result = $statement->get_result();
    while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($myorders, $row);
    }
}
$r = array();
$r['myorders'] = $myorders;
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($r);

}
?>