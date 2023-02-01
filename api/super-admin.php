<?php
include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $id = $data->id;

$students = array();
$business_owners = array();
$school_admins = array();


$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName);// database connection

// students
$students_sql = "SELECT id, name, department, email, phone  FROM users WHERE user_type=4";
$statement = $conn->prepare($students_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($students, $row);
    }
}

// business owners
$students_sql = "SELECT id, name, business_name, phone FROM users WHERE user_type=3";
$statement = $conn->prepare($students_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($business_owners, $row);
    }
}

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
$r['students']= $students;
$r['business_owners']= $business_owners;
$r['school_admins']= $school_admins;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header('content-type: text/json');

echo json_encode($r);
}
?>
