<?php
include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
$json = file_get_contents('php://input');
    $data = json_decode($json);
    $id = $data->id;
    $title = $data->title;
    $content = $data->content;
$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName);
$sql = "INSERT INTO advertisements (title, content,author) VALUES (?,?,?) ";
$statement = $conn->prepare($sql);
$statement->bind_param('sss', $title, $content,$id);
$statement->execute();
$result = $statement->get_result();

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

$r['myadvertisements'] = $advertisements;
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($r);
}