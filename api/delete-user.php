<?php
include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $uid = $data->uid;
    $id = $data->id;


$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName); // database connection

$sql = "DELETE FROM users WHERE id=?";
$statement = $conn->prepare($sql);
$statement->bind_param('s', $uid);
$statement->execute();
$result = $statement->get_result();


$students = array();
$sellers = array();
// students
$students_sql = "SELECT id, name, department FROM users WHERE user_type=4";
$statement = $conn->prepare($students_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($students, $row);
    }
}

// sellers
$sellers_sql = "SELECT id, name, business_name FROM users WHERE user_type=3";
$statement = $conn->prepare($sellers_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($sellers, $row);
    }
}
$school_admins = array();
// school admins
$students_sql = "SELECT id, name, email, phone FROM users WHERE user_type=2";
$statement = $conn->prepare($students_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($school_admins, $row);
    }
}

$r = array();
$r['students'] = $students;
$r['sellers'] = $sellers;
$r['school_admins']= $school_admins;
header('Access-Control-Allow-Origin: *');

// header('Access-Control-Allow-Methods: GET, POST');

// header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");

echo json_encode($r);

}

?>