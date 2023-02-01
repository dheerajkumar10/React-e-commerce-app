<?php
include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $id = $data->id;



$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName); // database connection
$orders = array();
// orders
$orders_sql = "SELECT orders.id,orders.quantity, products.name, users.name as buyer, users.department FROM orders LEFT JOIN products ON orders.product_id=products.id LEFT JOIN users ON users.id=orders.user_id where products.owner =$id";
$statement = $conn->prepare($orders_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($orders, $row);
    }
}




$myproducts = array();

//my products
$myproducts_sql = "SELECT * FROM products WHERE owner = $id";
$statement1 = $conn->prepare($myproducts_sql);
$statement1->execute();
$result1 = $statement1->get_result();
while ($row = $result1->fetch_assoc()) {
    if (!empty($row)) {
        $push = array('id'=>$row['id'],'name'=>$row['name'],'price'=>$row['price'],
        'image'=>base64_encode($row['product_image']));
        array_push($myproducts, $push);
    }
}

//myadvertisements
$advertisements=array();
$groups_sql = "SELECT a.id,a.title,a.content FROM advertisements a,users u where a.author = u.id and u.id=$id";
$statement = $conn->prepare($groups_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($advertisements, $row);
    }
}
$r = array();


$r = array();

$r['products'] = $myproducts;
$r['orders'] = $orders;
$r['myadvertisements'] = $advertisements;
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($r);
}
?>
