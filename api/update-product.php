<?php
include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    $pid = $_POST['pid'];
  $name = $_POST['name'];
$creator = $_POST['id'];
$price = $_POST['price'];
$product_image = $_FILES['image']['name'];
$product_image_tmp = $_FILES['image']['tmp_name'];
$imgContent = addslashes(file_get_contents($product_image_tmp)); 

$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName); // database connection

$sql = "UPDATE products
SET name = '$name', price= $price, product_image = '$imgContent'
WHERE id = $pid";
$statement = $conn->prepare($sql);
//$statement->bind_param();
$statement->execute();
$result = $statement->get_result();

$myproducts = array();

//my products
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



$r = array();

$r['products'] = $myproducts;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($r);

}

?>