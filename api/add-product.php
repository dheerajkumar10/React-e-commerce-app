<?php

include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
$name = $_POST['name'];
$creator = $_POST['id'];
$price = $_POST['price'];
$product_image = $_FILES['image']['name'];
$product_image_tmp = $_FILES['image']['tmp_name'];
$imgContent = addslashes(file_get_contents($product_image_tmp)); 
$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName); // database connection

$sql = "INSERT INTO products (name, price, owner, product_image) VALUES ('$name', '$price', '$creator', '$imgContent')";

$statement = $conn->prepare($sql);
//$statement->bind_param();
$statement->execute();
$result = $statement->get_result();

$products =array();
// products
$products_sql = "SELECT products.id, products.name, products.product_image, products.price, users.name AS seller, users.department FROM products INNER JOIN users ON users.id = products.owner";
$statement = $conn->prepare($products_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        $push = array('id'=>$row['id'],'name'=>$row['name'],'price'=>$row['price'],
        'seller'=>$row['seller'],'image'=>base64_encode($row['product_image']),'department'=>$row['department']);
        array_push($products, $push);
    }
}
$r = array();
$myproducts =array();
$myproducts_sql = "SELECT * FROM products WHERE owner = $creator";
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

$r['products'] = $products;
$r['myproducts'] = $myproducts;
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($r);
}
?>