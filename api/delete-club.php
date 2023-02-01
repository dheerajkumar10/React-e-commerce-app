<?php
include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $cid = $data->cid;
    $id = $data->id;


$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName); // database connection

$sql = "DELETE FROM clubs WHERE id=?";
$statement = $conn->prepare($sql);
$statement->bind_param('s', $cid);
$statement->execute();
$result = $statement->get_result();

$clubs = array();
// clubs
$groups_sql = "SELECT clubs.id, clubs.name, users.name AS creator, users.department FROM clubs LEFT JOIN users ON clubs.creator=users.id";
$statement = $conn->prepare($groups_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($clubs, $row);
    }
}

$r = array();

$r['clubs'] = $clubs;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($r);

}

?>