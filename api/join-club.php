<?php
include_once './cors.php';
ob_start();
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $id = $data->id;
    $club_id = $data->cid;

$dbName = "hxm7426_marketplace";
    
$conn = mysqli_connect("localhost", "hxm7426_harini", "Harini@21", $dbName);// database connection

$sql = "INSERT INTO club_member (user_id, club_id) VALUES (?,?) ";
$statement = $conn->prepare($sql);
$statement->bind_param('ss', $id, $club_id);
$statement->execute();
$result = $statement->get_result();

$my_club = array();

$myclub_sql = "SELECT users.name,c.cname,c.clubid from users, (SELECT clubs.creator as creator,club_member.id, users.id AS uid, users.name AS uname, clubs.name AS cname,clubs.id as clubid FROM users JOIN clubs JOIN club_member ON users.id = club_member.user_id AND clubs.id = club_member.club_id WHERE users.id = $id)  c where c.creator=users.id";
$statement = $conn->prepare($myclub_sql);
$statement->execute();
$result = $statement->get_result();
while ($row = $result->fetch_assoc()) {
    if (!empty($row)) {
        array_push($my_club, $row);
    }
}
$r = array();

$r['myclubs'] = $my_club;
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");

header("content-type: text/json");
echo json_encode($r);
}
?>