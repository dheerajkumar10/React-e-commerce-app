<?php

include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
$name = $_POST['name'];
$creator = $_POST['id'];
$content = $_POST['content'];
$imgContent="";
if($_FILES['image']['name']){
$product_image = $_FILES['image']['name'];
$product_image_tmp = $_FILES['image']['tmp_name'];
$imgContent = addslashes(file_get_contents($product_image_tmp)); }
$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName); // database connection

$sql = "INSERT INTO user_posts (content, image, author) VALUES ('$content', '$imgContent','$creator')";

$statement = $conn->prepare($sql);
//$statement->bind_param();
$statement->execute();
$result = $statement->get_result();


$posts =array();
// posts
$products_sql = "select user_posts.id,content,image,name from user_posts, users where users.id = user_posts.author";
$statement = $conn->prepare($products_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        $push = array('id'=>$row['id'],'content'=>$row['content'],'image'=>base64_encode($row['image']),'name'=>$row['name']);
        array_push($posts, $push);
    }
}

$r = array();
$r['posts'] = $posts;
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($r);
}
?>